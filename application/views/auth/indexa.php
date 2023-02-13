<!DOCTYPE html>
<html lang="pt-BR">

<?php $this->session->unset_userdata("logged_user"); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satulg</title>

    <link href="<?= base_url('assets/css/') ?>bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Core.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Status.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/') ?>fonts.css" rel="stylesheet" crossorigin="anonymous">

    <script src="<?= base_url('assets/js/') ?>bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>popper.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery.mask.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>Core.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/Class/') ?>Ajax.js" crossorigin="anonymous"></script>

    <script>
        window.onload = () => {
            <?php
                if($this->session->danger) {
                    echo 'alertaErro("'.$this->session->danger.'");';
                }
            ?>

            <?php
                if($this->session->success) {
                    echo 'alertaSucesso("'.$this->session->success.'");';
                }
            ?>

            <?php
                if($this->session->info) {
                    echo 'alertaInfo("'.$this->session->info.'");';
                }
            ?>
        }
    </script>

</head>

    <body class="text-center">
        <form class="form-signin" id="logar">
            <img class="mb-4 rounded-circle" src="<?php echo base_url('assets/img/') ?>logo.png" alt="" width="110" height="110">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>

            <label for="cpf" class="sr-only mb-1">CPF</label>
            <input type="text" format="cpf" id="cpf" class="form-control mb-3" placeholder="Digite seu CPF" required="" autofocus="" name="cpf">

            <label for="senha" class="sr-only mb-1">Senha</label>
            <input type="password" id="senha" class="form-control mb-3" placeholder="Digite sua senha" required="" name="senha">

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me" id="remember" checked name="remember"> Mantenha-me Logado
                </label>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            
        </form>

        <style>
            html,
            body {
                height: 100%;
            }

            body {
                display: -ms-flexbox;
                display: -webkit-box;
                display: flex;
                -ms-flex-align: center;
                -ms-flex-pack: center;
                -webkit-box-align: center;
                align-items: center;
                -webkit-box-pack: center;
                justify-content: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }

            .form-signin .checkbox {
                font-weight: 400;
            }

            .form-signin .form-control {
                position: relative;
                box-sizing: border-box;
                height: auto;
                padding: 10px;
                font-size: 16px;
            }

            .form-signin .form-control:focus {
                z-index: 2;
            }

            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }

            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>

    </body>

    <script>
        localStorage.removeItem("token");

        $("#logar").submit(function(e) {
            e.preventDefault();

            const dados = $("#logar").serializeArray();
            dados["remember"] = $("#remember").is(":checked");
            console.log(dados);

            Ajax.send_request("<?php echo site_url('/login') ?>", dados,
            (resultado) => {
                preloaderParar();
                console.log(resultado);
                alertaSucesso(resultado['mensagem']);

                if(typeof resultado["token"] != "undefined") {
                    Ajax.set_token(resultado["token"]);
                }
                
                setTimeout(() => {
                    location.href = '<?php echo site_url('/') ?>';
                }, 1000);
            },
            (error) => {
                preloaderParar();
                console.log(error);

                if(typeof error["responseJSON"] != "undefined") {
                    if(typeof error["responseJSON"]["mensagem"] != "undefined") {
                        alertaErro(error["responseJSON"]["mensagem"]);

                    }
                } else {
                    alertaErro("Erro ao editar");
                }

                console.error(error);
            }, "progress-bar-excluir", "POST")

        });
    </script>

</html>