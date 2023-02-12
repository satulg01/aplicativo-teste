<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Auth extends CI_Controller
{

    public function index()
    {
        $this->load->view("auth/index", '');
    }

    public function login()
    {

        if($this->verifyBlock()) {
            return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Número máximo de tentativas excedidas!', 'status' => '401']));
        }

        $this->verifyDdos();

        $this->load->model("user");

        $campos = $this->input->post();

        $pass = sha1($campos["senha"] . $_ENV['SECRET_KEY']);

        $resultado = $this->user->login(addslashes($campos["cpf"]), $pass);

        if (isset($resultado[0])) {
            $user = $resultado[0];

            $dados = array(
                "userId" => $user["id"],
                "document" => $user["document"],
                "access" => $user["access"]
            );

            $token = $this->token($dados);
            $this->session->set_userdata("logged_user", $user);

            return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Logado com sucesso!', 'status' => '200', 'token' => $token]));
        } else {
            $this->load->model("blocked");

            $dados = array (
                "ip" => $this->getClientIp(),
                "user" =>  $campos["cpf"],
                "pass" =>  $campos["senha"]
            );

            $this->blocked->insert_login_attemp($dados);

            return $this->output->set_content_type("json")->set_status_header(404)->set_output(json_encode(['mensagem' => 'Usuário e senha não conferem!', 'status' => '404']));
        }
    }

    public function logout() {
        $this->session->unset_userdata("logged_user");
        redirect("login");
    }

    public function token($dados)
    {
        $jwt = new JWT();

        $JwtSecretKey = $_ENV['SECRET_KEY'];


        $token = $jwt->encode($dados, $JwtSecretKey);
        return $token;
    }

    public function verifyBlock()
    {
        $this->load->model("blocked");
        return $this->blocked->blocked_ips($this->getClientIp());
    }


    public function verifyDdos()
    {
        $this->load->model("blocked");

        $tentativas = $this->blocked->get_ip_attemps($this->getClientIp());
        
        if(count($tentativas) >= 2) {
            $this->blocked->insert_blocked_ip($this->getClientIp());
        }
    }

    function getClientIp() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
