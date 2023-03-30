<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Blocked extends CI_Model {
	

	

	public function login($document, $password)
	{
		return $this->db->query("SELECT `users`.* FROM `users` WHERE `document` = '$document' AND `pass` = '$password'")->result_array();
	}
}