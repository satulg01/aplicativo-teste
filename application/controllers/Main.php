<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		verifyPermission();
	}
	
	public function index()
	{
		$this->load->view('home/index');
	}
}
