<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
	private $data = array(
		'title' => 'Pedidos',
		'comeback' => 'pedidos'
	);

	public function __construct()
	{
		parent::__construct();

		$user = getLoggedUser();
		$this->data["user"] = $user;

		$this->load->model("order");
		$this->load->model("collaborator");
		$this->load->model("product");
		$this->load->model("user");
	}

	public function index()
	{	
		$this->data["orders"] = $this->order->getAll(["date_sale", "desc"]);

		$page = $this->load->view('orders/index', $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function add()
	{
		verifyPermission();

		$page = $this->load->view("orders/add", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function edit($id)
	{
		verifyPermission();

		$this->data["order"] = $this->order->get($id);

		$page = $this->load->view("orders/edt", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function insert()
	{
		verifyPermission();

		$order = $this->input->post();

		$itens = json_decode($order["produtos"], true);

		#Removo para o model não tentar adicionar
		unset($order["produtos"]);
		
		if(!count($itens)) {
			return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Selecione ao menos um item!', 'status' => '401']));
		}
		
		try {
			verifyAuthToken($order["token"]);

			#Removo para o model não tentar adicionar
			unset($order["token"]);
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}

		try {
			
			$order["user_id"] = $this->session->logged_user["id"];

			$id_pedido = $this->order->insert($order);

			foreach ($itens as $x => $item) {
				$item["value_final"] = $item["quantity"] * $item["value"];
				$item["order_id"] = $id_pedido;

				$this->order->insertItem($item);
			}

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Pedido inserido com sucesso!', 'status' => '200']));

		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Erro ao inserir!', 'status' => '500']));
		}
	}

	public function update()
	{
		verifyPermission();

		$order = $this->input->input_stream();
		
		$itens = json_decode($order["produtos"], true);

		#Removo para o model não tentar adicionar
		unset($order["produtos"]);
		

		try {
			verifyAuthToken($order["token"]);

			#Removo para o model não tentar adicionar
			unset($order["token"]);

		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}


		try {

			$orderOld = $this->order->get($order["id"]);

			$order["user_id"] = $this->session->logged_user["id"];

			if($orderOld["status"] != 1) {
				return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Pedidos finalizados não podem ser altrerados!', 'status' => '401']));
			}
			
			$this->order->update($order);

			#Capturo os ids dos itens que tem no pedido
			$itensIdsArray = $this->order->getItemWhere([["order_id", "=", $order["id"]]]);

			$itensIds = array();
			foreach ($itensIdsArray as $x => $item) {
				$itensIds[$item["id"]] = true;
			}

			
			foreach ($itens as $x => $item) {
				$item["value_final"] = $item["quantity"] * $item["value"];
				$item["order_id"] = $order["id"];

				if(isset($item["id"])) {
					$this->order->updateItem($item);

					#Tiro o id do meu array de id dos itens pq os que sobrarem nao estao na tela entao foram deletados
					unset($itensIds[$item["id"]]);
				} else {
					$this->order->insertItem($item);
				}
			}

			#Deleto os itens efetivamente
			foreach ($itensIds as $itemToExclude => $x) {
				$this->order->deleteItem($itemToExclude);
			}

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Pedido editado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function reactivate()
	{
		verifyPermission();
		try {
			verifyAuthToken($this->input->input_stream("token"));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}

		try {
			$order = ["id" => $this->input->input_stream("id"), "status" => 1];

			$this->order->update($order);

			$userActual = $this->user->getByorder($this->input->input_stream("id"));
			
			if(isset($userActual[0])) {
				$userActual = $userActual[0];

				$this->user->update(["id" => $userActual["id"], "status" => 1]);
			}

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Pedido reativado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function finalized()
	{
		$requesHeaders = $this->input->request_headers();

		if(!isset($requesHeaders["token"])) {
			return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'O token deve ser inserido no cabeçalho "API Key" com a chave "Token"!', 'status' => '401']));
		}

		try {
			verifyAuthToken($requesHeaders["token"]);
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '401']));
		}

		/* Vendas Finalizadas */
		$orders = $this->order->getWhere([["status", "=", 2]]);

		/* Produtos */
		$array_products = $this->product->getWhere([]);
		$products = array();
		foreach ($array_products as $x => $product) {
			$products[$product["id"]] = $product;
		}

		/* Colaboradores */
		$array_collaborators = $this->collaborator->getWhere([]);
		$collaborators = array();
		foreach ($array_collaborators as $x => $collaborator) {
			$collaborators[$collaborator["id"]] = $collaborator;
		}

		/* Usuarios */
		$array_users = $this->user->get();
		$users = array();
		foreach ($array_users as $x => $user) {
			$users[$user["id"]] = $user;
		}

		foreach ($orders as $x => $order) {
			$orderItems = $this->order->getItemWhere([["order_id", "=", $order["id"]]]);

			foreach ($orderItems as $y => $orderItem) {
				$orderItems[$y]["product_name"] = $products[$orderItem["item_id"]]["name"];
			}

			$orders[$x]["supplier_name"] = $collaborators[$order["supplier_id"]]["name"];
			$orders[$x]["seller_name"] = $users[$order["user_id"]]["name"];
			$orders[$x]["products"] = $orderItems;
			
		}

		return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode($orders));
	}
}
