<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    private $data = array();

	public function __construct()
	{
		parent::__construct();

		$loggedUser = $this->session->userdata("logged_user");
		$this->load->model("user");
		$userLoggedFromDB = $this->user->getWhere(["id", $loggedUser["id"]])[0];

        if(!$loggedUser) {
            return redirect("login");
        } else if($userLoggedFromDB["status"] != 1) {
            return redirect("login");
        }

		$this->data["user"] = $userLoggedFromDB;
	}
	
	public function __destruct() {
		$this->db->close();
	}
	
	public function index()
	{
		$this->load->view('home/index', $this->data);
	}
}
