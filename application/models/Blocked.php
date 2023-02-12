<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Blocked extends CI_Model {
	public $blockTime = 10;

	public function insert_login_attemp($dados)
	{
		return $this->db->query("INSERT INTO `login_attemps` SET `ip` = '$dados[ip]', `user` = '$dados[user]', `pass` = '$dados[pass]'");
	}

	public function get_ip_attemps($ip)
	{
		$minutosAtras = date("Y-m-d H:i:s", strtotime("-$this->blockTime minutes"));

		return $this->db->query("SELECT `login_attemps`.* FROM `login_attemps` WHERE `date` >= '$minutosAtras'")->result_array();
	}

	public function blocked_ips($ip)
	{
		$agora = date("Y-m-d H:i:s");
		return $this->db->query("SELECT `blocked_ips`.* FROM `blocked_ips` WHERE `ip` = '$ip' AND `block_expires` >= '$agora'")->result_array();
	}

	public function insert_blocked_ip($ip)
	{
		$minutosAfrente = date("Y-m-d H:i:s", strtotime("+$this->blockTime minutes"));

		return $this->db->query("INSERT INTO `blocked_ips` SET `ip` = '$ip', `block_expires` = '$minutosAfrente'");
	}

	public function login($document, $password)
	{
		return $this->db->query("SELECT `users`.* FROM `users` WHERE `document` = '$document' AND `pass` = '$password'")->result_array();
	}
}