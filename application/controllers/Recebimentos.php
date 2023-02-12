<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recebimentos extends CI_Controller
{
	private $data = array(
		'title' => 'Recebimentos',
		'comeback' => 'recebimentos'
	);

	public function __construct()
	{
		parent::__construct();
		verifyPermission();
	}
	

	public function index()
	{
		//Carrego a model de recebimentos
		$this->load->model("recebimento");

		//Jogo no meu array principal  todos os meus recebimentos
		$this->data["recebimentos"] = $this->recebimento->getAll(["data", "asc"]);

		//Carrego a view
		$page = '';
		$page .= $this->load->view('components/html/header', $this->data, TRUE);
		$page .= $this->load->view('pages/contas_receber/main', $this->data, TRUE);
		$page .= $this->load->view('components/html/footer', $this->data, TRUE);

		//Exemplo de retorno de JSON
		//$this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode($this->recebimento->getAll()));
		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
	}

	public function add()
	{

		$page = '';
		$page .= $this->load->view('components/html/header', $this->data, TRUE);

		$page .= $this->load->view("pages/contas_receber/add", '', TRUE);

		$page .= $this->load->view('components/html/footer', '', TRUE);


		//Aqui eu seto as config de saída 
		$this->output->set_content_type("html")->set_status_header(200)->set_output($page);
		//https://codeigniter.com/userguide3/libraries/output.html

	}

	public function insert()
	{
		$this->load->model("recebimento");

		$dataInicial = $this->input->post("data");
		$qtdMeses = $this->input->post("recorrencia");

		$dataRecebimento = $dataInicial;
		$i = 0;
		try {
			do {
				$recebimento = array(
					"valor" => $this->input->post("valor"),
					"identificador" => $this->input->post("identificador"),
					"data" => $dataRecebimento
				);

				$this->recebimento->insert($recebimento);


				$dataRecebimento = date("Y-m-d", strtotime($dataRecebimento . "+1 month"));
				$i++;
			} while ($i <= $qtdMeses);

			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Recebimento inserido com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function delete()
	{
		$this->load->model("recebimento");
		$recebimento = array(
			"id" => $this->input->input_stream("recordset")
		);

		try {
			$this->recebimento->delete($recebimento);
			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Recebimento apagado com sucesso!', 'status' => '200', "id" => $this->input->input_stream("recordset")]));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function update()
	{
		$this->load->model("recebimento");

		$recebimento = array(
			"id" => $this->input->input_stream("recordset"),
			"valor" => $this->input->input_stream("valor"),
			"identificador" => $this->input->input_stream("identificador"),
			"data" => $this->input->input_stream("data")
		);

		try {
			$this->recebimento->update($recebimento);
			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Recebimento editado com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}


	public function pay()
	{
		$this->load->model("recebimento");

		$recebimento = array(
			"id" => $this->input->input_stream("recordset"),
			"status" => 2
		);

		try {
			$this->recebimento->update($recebimento);
			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Recebimento pago com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}

	public function unpay()
	{
		$this->load->model("recebimento");

		$recebimento = array(
			"id" => $this->input->input_stream("recordset"),
			"status" => 1
		);

		try {
			$this->recebimento->update($recebimento);
			return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Recebimento despago com sucesso!', 'status' => '200']));
		} catch (\Throwable $th) {
			return $this->output->set_content_type("html")->set_status_header(500)->set_output($th);
		}
	}
}
