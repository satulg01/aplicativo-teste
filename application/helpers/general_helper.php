<?php 
if(!function_exists('verifyAuthToken')){
    function verifyAuthToken($token){
        $jwt = new JWT();
        $jwtSecret = $_ENV['SECRET_KEY'];
        $verification = $jwt->decode($token, $jwtSecret, 'HS256');

        $verification_json = $jwt->jsonEncode($verification);
        return $verification_json;

    }
}

if(!function_exists('verifyPermission')){
    function verifyPermission(){
        $ci = get_instance();

        $loggedUser = $ci->session->userdata("logged_user");

        if(!$loggedUser) {
            $ci->session->set_flashdata("danger", "Você precisa estar logado!");
            redirect("login");
        } else if($loggedUser["status"] != 1) {
            $ci->session->set_flashdata("danger", "Seu acesso está inativo!");
            redirect("login");
        }
    }
}

?>