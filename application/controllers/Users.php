<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->load->model("user");
		print_r($this->user->getAll());
	}

	public function __destruct() {
		$this->db->close();
	}
}
