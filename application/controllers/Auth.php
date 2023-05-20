<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('America/Sao_Paulo');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user");
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function index()
    {
        $this->load->view("auth/index");
    }


    public function cpfValidator($param)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $param);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        // if (preg_match('/(\d)\1{10}/', $cpf)) {
        //     return false;
        // }

        // // Faz o calculo para validar o CPF
        // for ($t = 9; $t < 11; $t++) {
        //     for ($d = 0, $c = 0; $c < $t; $c++) {
        //         $d += $cpf[$c] * (($t + 1) - $c);
        //     }
        //     $d = ((10 * $d) % 11) % 10;
        //     if ($cpf[$c] != $d) {
        //         return false;
        //     }
        // }
        return true;
    }

    public function login()
    {

        if ($this->verifyBlock()) {
            return $this->output->set_content_type("json")->set_status_header(401)->set_output(json_encode(['mensagem' => 'Número máximo de tentativas excedidas!', 'status' => '401']));
        }
        
        #'rules' => 'trim|required|is_unique[users.document]|regex_match[/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/]'

        $config = array(
            array(
                'field' => 'txtCpf',
                'label' => 'CPF',
                'rules' => 'trim|required|callback_cpfValidator',
                'errors' => array(
                    'cpfValidator' => 'O campo CPF não está em um formato correto.'
                )
            ),
            array(
                'field' => 'txtSenha',
                'label' => 'Senha',
                'rules' => 'trim|required|min_length[3]',
            ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view("auth/index");

        } else {
            $resultado = $this->user->login($this->input->post('txtCpf'), $this->input->post('txtSenha'));

            if(!empty($resultado)) {
                $this->session->set_userdata("logged_user", $resultado[0]);
                return redirect("/");
            } else {
                $this->load->view("auth/index", array('validation_errors' => "Usuário e/ou senha inválidos!"));
                return $this->user->insert_ip_attemp($this->getClientIp());
            }
        }

        



        #if(!isset($campos["cpf"]) || $campos["cpf"] == "") {
        #    return $this->output->set_content_type("json")->set_status_header(403)->set_output(json_encode(['mensagem' => 'O campo "cpf" é necessário!', 'status' => '403']));
        #}
        #if(!isset($campos["senha"]) || $campos["senha"] == "") {
        #    return $this->output->set_content_type("json")->set_status_header(404)->set_output(json_encode(['mensagem' => 'O campo "senha" é necessário!', 'status' => '404']));
        #}


        // $pass = sha1($campos["senha"] . $_ENV['SECRET_KEY']);


        // if (isset($resultado[0])) {
        //     $user = $resultado[0];

        //     if ($user["status"] != 1) {
        //         return $this->output->set_content_type("json")->set_status_header(404)->set_output(json_encode(['mensagem' => 'Seu acesso está inativo!', 'status' => '404']));
        //     }

        //     $dados = array(
        //         "userId" => $user["id"],
        //         "document" => $user["document"],
        //         "access" => $user["access"]
        //     );

        //     $token = $this->token($dados);
        //     $this->session->set_userdata("logged_user", $user);

        //     return $this->output->set_content_type("json")->set_status_header(200)->set_output(json_encode(['mensagem' => 'Logado com sucesso!', 'status' => '200', 'token' => $token]));
        // } else {
            
        //     $this->verifyDdos();

        //     return $this->output->set_content_type("json")->set_status_header(404)->set_output(json_encode(['mensagem' => 'Usuário e senha não conferem!', 'status' => '404']));
        // }
    }

    public function logout()
    {
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
        return $this->user->blocked_ips($this->getClientIp());
    }


    public function verifyDdos()
    {

        $tentativas = $this->user->get_ip_attemps($this->getClientIp());

        if (count($tentativas) >= 3) {
            $this->user->insert_blocked_ip($this->getClientIp());
        }
    }

    function getClientIp()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}