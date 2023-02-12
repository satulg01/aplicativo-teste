<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recebimento extends CI_Model
{

	public function getAll($orderBy = [])
	{
		$this->db->from("recebimentos");
		$this->db->order_by(''.implode(' ', $orderBy).'');
		$query = $this->db->get(); 
		return $query->result_array();
	}


	public function insert($recebimento)
	{
		return $this->db->insert("recebimentos", $recebimento);
	}


	public function delete($recebimento)
	{
		$this->db->delete('recebimentos', array('id' => $recebimento["id"]));
	}


	public function update($recebimento)
	{
		$this->db->where('id', $recebimento['id']);
		
		unset($recebimento['id']);

		$this->db->set($recebimento);
		return $this->db->update('recebimentos', $recebimento);
		
	}
}
