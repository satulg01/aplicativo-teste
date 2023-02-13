<!doctype html>
<html lang="pt-BR">

<?php $this->session->unset_userdata("logged_user"); ?>

<head>
    <title>Satulg</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    
    <link href="<?= base_url('assets/css/') ?>Core.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Status.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/') ?>fonts.css" rel="stylesheet" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo site_url('/assets') ?>/auth/css/style.css">

    

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

<body class="img js-fullheight" style="background-image: url(<?php echo site_url('/assets') ?>/auth/images/background.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Sistema Teste</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Login</h3>
                        <form action="#" class="signin-form" id="logar">
                            <div class="form-group">
                                <input type="text" format="cpf" id="cpf" class="form-control" placeholder="CPF" required="" autofocus="" name="cpf" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <input id="senha" type="password" class="form-control" placeholder="Senha" required="" name="senha">
                                <span toggle="#senha" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Entrar</button>
                            </div>

                            <div class="form-group d-md-flex">
                                <div class="w-60">
                                    <label class="checkbox-wrap checkbox-primary">Mantenha-me Logado
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo site_url('/assets') ?>/auth/js/jquery.min.js"></script>

    <script src="<?= base_url('assets/js/') ?>jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery.mask.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>Core.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/Class/') ?>Ajax.js" crossorigin="anonymous"></script>

    <script src="<?php echo site_url('/assets') ?>/auth/js/popper.js"></script>
    <script src="<?php echo site_url('/assets') ?>/auth/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url('/assets') ?>/auth/js/main.js"></script>

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

</body>

</html>