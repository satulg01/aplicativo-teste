<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$loggedUser = $this->session->userdata("logged_user");
		$this->load->model("user");
		$userLoggedFromDB = $this->user->getWhere(["id", $loggedUser["id"]])[0];

        if(!$loggedUser) {
            redirect("login");
        } else if($userLoggedFromDB["status"] != 1) {
            redirect("login");
        }
	}
	
	public function index()
	{
		$this->load->view('home/index');
	}
}
