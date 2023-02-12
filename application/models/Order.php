<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Model
{

	public function get($id)
	{
		$query = $this->db->query("SELECT `orders`.* FROM `orders` WHERE `orders`.`id` = '$id'");
		return $query->result_array()[0];
	}

	public function getAll($orderBy = [])
	{
		$query = $this->db->query("SELECT `orders`.* FROM `orders` ORDER BY $orderBy[0] $orderBy[1]");
		return $query->result_array();
	}

	public function getWhere($where = [])
	{
		$stringInsert = "";
		foreach($where as $campo => $valor) {
			$stringInsert .= " AND `". $valor[0] ."` ".$valor[1]." '" . addslashes($valor[2]) . "' ";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$query = $this->db->query("SELECT `orders`.* FROM `orders` WHERE 1 $stringInsert");
		return $query->result_array();
	}

	


	public function insert($order)
	{
		$stringInsert = "";
		foreach($order as $campo => $valor) {
			$stringInsert .= " `". $campo ."`  = '" . addslashes($valor) . "',";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$string_consulta = "INSERT INTO `orders` SET " . $stringInsert;

		$this->db->query($string_consulta);

		return $this->db->conn_id->insert_id;
	}
	

	


	public function update($order)
	{
		$id = $order["id"];

		unset($order["id"]);

		$sql = "UPDATE `orders` SET ";

		foreach($order as $key => $value) {
			$sql .= "`" .$key. "` = '" . addslashes($value) . "', "; 
		}

		$sql = trim($sql, ' ');
		$sql = trim($sql, ',');

		$sql .= " WHERE `id` = '$id'";

		return $this->db->query($sql);
		
	}



	/* PRODUTOS DOS PEDIDOS */

	public function getItemWhere($where = [])
	{
		$stringInsert = "";
		foreach($where as $campo => $valor) {
			$stringInsert .= " AND `". $valor[0] ."` ".$valor[1]." '" . addslashes($valor[2]) . "' ";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$query = $this->db->query("SELECT `orders_items`.* FROM `orders_items` WHERE 1 $stringInsert");
		return $query->result_array();
	}

	public function insertItem($order)
	{
		$stringInsert = "";
		foreach($order as $campo => $valor) {
			$stringInsert .= " `". $campo ."`  = '" . addslashes($valor) . "',";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$string_consulta = "INSERT INTO `orders_items` SET " . $stringInsert;

		$this->db->query($string_consulta);

		return $this->db->conn_id->insert_id;
	}

	public function updateItem($order)
	{
		$id = $order["id"];

		unset($order["id"]);

		$sql = "UPDATE `orders_items` SET ";

		foreach($order as $key => $value) {
			$sql .= "`" .$key. "` = '" . addslashes($value) . "', "; 
		}

		$sql = trim($sql, ' ');
		$sql = trim($sql, ',');

		$sql .= " WHERE `id` = '$id'";

		return $this->db->query($sql);
		
	}

	public function deleteItem($id)
	{
		return $this->db->query("DELETE FROM `orders_items` WHERE `orders_items`.`id` = '$id'");
	}

}
