<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collaborator extends CI_Model
{

	public function get($id = 0, $orderBy = [])
	{
		$this->db->reconnect();

		if(empty($id)) {
			$query = $this->db->get('collaborators');
		} 
		else 
		{
			$this->db->limit(1);
			$query = $this->db->get_where('collaborators', array('id' => $id));
		}

		if(!empty($orderBy)) {
			$this->db->order_by($orderBy["campo"], $orderBy["ordem"]);
		}


		return $query->result_array();
	}

	public function getAll($orderBy = [])
	{
		$query = $this->db->query("SELECT `collaborators`.* FROM `collaborators` ORDER BY $orderBy[0] $orderBy[1]");
		return $query->result_array();
	}

	public function getWhere($where = [])
	{
		$stringInsert = "";
		foreach($where as $campo => $valor) {
			$stringInsert .= " AND `". $valor[0] ."` ".$valor[1]." '" . addslashes($valor[2]) . "' ";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$query = $this->db->query("SELECT `collaborators`.* FROM `collaborators` WHERE 1 $stringInsert");
		return $query->result_array();
	}


	public function insert($collaborator)
	{
		$stringInsert = "";
		foreach($collaborator as $campo => $valor) {
			$stringInsert .= " `". $campo ."`  = '" . addslashes($valor) . "',";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$string_consulta = "INSERT INTO `collaborators` SET " . $stringInsert;

		$this->db->query($string_consulta);

		return $this->db->conn_id->insert_id;
	}


	public function update($collaborator)
	{
		$id = $collaborator["id"];

		unset($collaborator["id"]);

		$sql = "UPDATE `collaborators` SET ";

		foreach($collaborator as $key => $value) {
			$sql .= "`" .$key. "` = '" . addslashes($value) . "', "; 
		}

		$sql = trim($sql, ' ');
		$sql = trim($sql, ',');

		$sql .= " WHERE `id` = '$id'";

		return $this->db->query($sql);
		
	}
}
