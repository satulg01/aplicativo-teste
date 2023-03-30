<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collaborators extends CI_Controller
{
	private $data = array(
		'title' => 'Colaboradores',
		'comeback' => 'colaboradores'
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

		$this->load->library('form_validation');
		$this->load->model("collaborator");
		$this->load->model("user");
	}
	
	public function __destruct() {
		$this->db->close();
	}

	public function index()
	{

		//Jogo no meu array principal  todos os colaboradores
		$this->data["collaborators"] = $this->collaborator->getAll(["name", "asc"]);

		//Carrego a view
		$page = $this->load->view('collaborators/index', $this->data, TRUE);

		//Exemplo de retorno de JSON
		//$this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode($this->recebimento->getAll()));
		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function add()
	{

		$page = $this->load->view("collaborators/add", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function edit($id)
	{
		$this->data["collaborator"] = $this->collaborator->get($id);

		$page = $this->load->view("collaborators/edt", $this->data, TRUE);

		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function insert()
	{
		$collaborator = $this->input->post();

		print_r($collaborator);
		exit;

		$config = array(
                array(
                    'field' => 'txtCodigo',
                    'label' => 'Código',
                    'rules' => 'trim|required|integer|max_length[10]'
                ),
			);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() == FALSE) {

		} else {

		}



			if($this->collaborator->getWhere($camposWhere)) {
				return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'CPF já cadastrado na nossa base de dados!', 'status' => '401']));
			}

			$id_colaborador = $this->collaborator->insert($collaborator);


			$pedacosNome = explode(" ", $collaborator["name"]);
			$usuario = $pedacosNome[0];
			
			if($collaborator["type"] == 2) {
				$collaborator["status"] = 0;
			}

			$user = array(
				"name" => $collaborator["name"],
				"document" => $collaborator["document"],
				"user" => $usuario,
				"pass" => sha1("123" . $_ENV['SECRET_KEY']),
				"access" => $collaborator["access"],
				"id_collaborator" => $id_colaborador,
				"status" => $collaborator["status"],
			);

			$this->user->insert($user);

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Colaborador inserido com sucesso!', 'status' => '200']));
	}


	public function update()
	{
		$collaborator = $this->input->input_stream();

		try {
			verifyAuthToken($collaborator["token"]);
			unset($collaborator["token"]);
		} catch (\Throwable $th) {
			return $this->output->set_content_type("json")->set_status_header(500)->set_output(json_encode(['mensagem' => 'Token de acesso inválido!', 'status' => '501']));
		}


		try {

			$collaboratorOld = $this->collaborator->get($this->input->input_stream("id"));

			$camposWhere = array(
				["document", "=", $collaboratorOld["document"]],
				["id", "!=", $collaboratorOld["id"]]
			);

			if($this->collaborator->getWhere($camposWhere)) {
				return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'CPF já cadastrado na nossa base de dados!', 'status' => '401']));
			}

			if($collaboratorOld["status"] != 1) {
				return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Colaboradores inativos não podem ser altrerados!', 'status' => '401']));
				exit;
			}
			
			$this->collaborator->update($collaborator);


			$pedacosNome = explode(" ", $collaborator["name"]);
			$usuario = $pedacosNome[0];
			
			$userActual = $this->user->getByCollaborator($this->input->input_stream("id"));


			if($collaborator["type"] == 2) {
				$collaborator["status"] = 0;
			}

			if(isset($userActual[0])) {
				$userActual = $userActual[0];

				$user = array(
					"id" => $userActual["id"],
					"name" => $collaborator["name"],
					"document" => $collaborator["document"],
					"user" => $usuario,
					"access" => $collaborator["access"],
					"status" => $collaborator["status"],
				);
				$this->user->update($user);
			}
			

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Colaborador editado com sucesso!', 'status' => '200']));
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

		try {
			$collaborator = ["id" => $this->input->input_stream("id"), "status" => 1];

			$this->collaborator->update($collaborator);

			$userActual = $this->user->getByCollaborator($this->input->input_stream("id"));
			
			if(isset($userActual[0])) {
				$userActual = $userActual[0];

				$this->user->update(["id" => $userActual["id"], "status" => 1]);
			}

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Colaborador reativado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}
}
