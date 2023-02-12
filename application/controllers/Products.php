<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
	private $data = array(
		'title' => 'Produtos',
		'comeback' => 'Produtos'
	);

	public function __construct()
	{
		parent::__construct();
		verifyPermission();

		$user = getLoggedUser();
		$this->data["user"] = $user;
		
		if($user["access"] == "V") {
            $this->session->set_flashdata("danger", "Você não tem permissão para acessar!");
			redirect("/");
		}
	}
	

	public function index()
	{
		//Carrego a model de Produtoes
		$this->load->model("product");

		//Jogo no meu array principal  todos os Produtoes
		$this->data["products"] = $this->product->getAll(["name", "asc"]);

		//Carrego a view
		$page = $this->load->view('products/index', $this->data, TRUE);

		//Exemplo de retorno de JSON
		//$this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode($this->recebimento->getAll()));
		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function add()
	{

		$page = $this->load->view("products/add", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function edit($id)
	{
		$this->load->model("product");

		$this->data["product"] = $this->product->get($id);

		$page = $this->load->view("products/edt", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function insert()
	{
		$product = $this->input->post();

		try {
			verifyAuthToken($product["token"]);
			unset($product["token"]);
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}

		$this->load->model("product");
		
		try {

			$this->product->insert($product);

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Produto inserido com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Erro ao inserir!', 'status' => '500']));
		}
	}


	public function update()
	{
		$product = $this->input->input_stream();

		try {
			verifyAuthToken($product["token"]);
			unset($product["token"]);
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}


		$this->load->model("product");

		try {

			$productOld = $this->product->get($this->input->input_stream("id"));

			if($productOld["status"] != 1) {
				return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Produtoes inativos não podem ser altrerados!', 'status' => '401']));
				exit;
			}
			
			$this->product->update($product);

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Produto editado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function reactivate()
	{
		try {
			verifyAuthToken($this->input->input_stream("token"));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}


		$this->load->model("product");

		try {
			$product = ["id" => $this->input->input_stream("id"), "status" => 1];

			$this->product->update($product);

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Produto reativado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}
}
