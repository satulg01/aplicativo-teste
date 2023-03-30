<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	public $blockTime = 10;

	public function login()
	{
        $pass = sha1($this->input->post('txtSenha') . $_ENV['SECRET_KEY']);

        $this->db->select('id, name, id_collaborator, id_collaborator, document, pass, access, token, status');
        $this->db->from('users');
        $this->db->where('pass', $pass);
        $this->db->where('document', $this->input->post('txtCpf'));
	
		$query = $this->db->get();
        return $query->result_array();
	}

	public function insert_ip_attemp($ip)
	{
		$dados = array(
			"ip" => $ip,
			"user" => $this->input->post('txtCpf'),
			"pass" => $this->input->post('txtSenha')
		);
	
		return $this->db->insert('login_attemps', $dados);
	}

	public function get_ip_attemps($ip)
	{
		$minutosAtras = date("Y-m-d H:i:s", strtotime("-$this->blockTime minutes"));

		$this->db->select('*');
        $this->db->from('login_attemps');
        $this->db->where('date >=', $minutosAtras);
	
		$query = $this->db->get();
        return $query->result_array();
	}

	public function blocked_ips($ip)
	{
		$agora = date("Y-m-d H:i:s");

		$this->db->select('*');
        $this->db->from('blocked_ips');
        $this->db->where('ip', $ip);
        $this->db->where('block_expires >=', $agora);
	
		$query = $this->db->get();
        return $query->result_array();
	}

	public function insert_blocked_ip($ip)
	{
		$minutosAfrente = date("Y-m-d H:i:s", strtotime("+$this->blockTime minutes"));
		
		$dados = array(
			"ip" => $ip,
			"block_expires" => $minutosAfrente
		);
	
		return $this->db->insert('blocked_ips', $dados);
	}
















	public function get()
	{
		return $this->db->query("SELECT `users`.* FROM `users`")->result_array();
	}

	public function getWhere($where = [])
	{
		$query = $this->db->query("SELECT `users`.* FROM `users` WHERE `$where[0]` = '$where[1]'");
		return $query->result_array();
	}

	public function getByCollaborator($id_collaborator)
	{
		return $this->db->query("SELECT `users`.* FROM `users` WHERE `id_collaborator` = '$id_collaborator'")->result_array();
	}



	public function insert($user)
	{
		$stringInsert = "";
		foreach($user as $campo => $valor) {
			$stringInsert .= " `". $campo ."`  = '" . addslashes($valor) . "',";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$string_consulta = "INSERT INTO `users` SET " . $stringInsert;

		$this->db->query($string_consulta);

		return $this->db->conn_id->insert_id;
	}


	public function update($user)
	{
		$id = $user["id"];

		unset($user["id"]);

		$sql = "UPDATE `users` SET ";

		foreach($user as $key => $value) {
			$sql .= "`" .$key. "` = '" . addslashes($value) . "', "; 
		}

		$sql = trim($sql, ' ');
		$sql = trim($sql, ',');

		$sql .= " WHERE `id` = '$id'";

		return $this->db->query($sql);
		
	}
}