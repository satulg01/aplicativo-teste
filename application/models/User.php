<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function get($id)
	{
		return $this->db->query("SELECT `users`.* FROM `users`")->result_array();
	}

	public function getWhere($orderBy = [])
	{
		$query = $this->db->query("SELECT `users`.* FROM `users` WHERE `$orderBy[0]` = '$orderBy[1]'");
		return $query->result_array();
	}

	public function getByCollaborator($id_collaborator)
	{
		return $this->db->query("SELECT `users`.* FROM `users` WHERE `id_collaborator` = '$id_collaborator'")->result_array();
	}

	public function login($document, $password)
	{
		return $this->db->query("SELECT `users`.* FROM `users` WHERE `document` = '$document' AND `pass` = '$password'")->result_array();
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