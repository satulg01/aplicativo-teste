<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Model
{

	public function get($id)
	{
		$query = $this->db->query("SELECT `products`.* FROM `products` WHERE `products`.`id` = '$id'");
		return $query->result_array()[0];
	}

	public function getAll($orderBy = [])
	{
		$query = $this->db->query("SELECT `products`.* FROM `products` ORDER BY $orderBy[0] $orderBy[1]");
		return $query->result_array();
	}

	public function getWhere($where = [])
	{
		$stringInsert = "";
		foreach($where as $campo => $valor) {
			$stringInsert .= " AND `". $valor[0] ."` ".$valor[1]." '" . addslashes($valor[2]) . "' ";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$query = $this->db->query("SELECT `products`.* FROM `products` WHERE 1 $stringInsert");
		return $query->result_array();
	}


	public function insert($product)
	{
		$stringInsert = "";
		foreach($product as $campo => $valor) {
			$stringInsert .= " `". $campo ."`  = '" . addslashes($valor) . "',";
		}
		$stringInsert = substr($stringInsert, 0, -1);
		
		$string_consulta = "INSERT INTO `products` SET " . $stringInsert;
		
		return $this->db->query($string_consulta);
	}


	public function update($product)
	{
		$id = $product["id"];

		unset($product["id"]);

		$sql = "UPDATE `products` SET ";

		foreach($product as $key => $value) {
			$sql .= "`" .$key. "` = '" . addslashes($value) . "', "; 
		}

		$sql = trim($sql, ' ');
		$sql = trim($sql, ',');

		$sql .= " WHERE `id` = '$id'";

		return $this->db->query($sql);
		
	}
}
