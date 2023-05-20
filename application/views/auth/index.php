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
                        
                        <?php if(isset($validation_errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $validation_errors; ?>
                            </div>
                        <?php endif ?>

                        <?php $attributes = array('class' => 'signin-form', 'id' => 'logar', 'name' => 'formLogin'); ?>
                        <?php echo form_open('login', $attributes); ?>
                            <div class="form-group">
                                <input type="text" format="cpf" id="cpf" class="form-control" value="<?php echo set_value('txtCpf'); ?>" placeholder="CPF" required="" autofocus="" name="txtCpf" autocomplete="off">
                                <?php echo form_error('txtCpf'); ?>
                            </div>

                            <div class="form-group">
                                <input id="senha" type="password" class="form-control" value="<?php echo set_value('txtSenha'); ?>" placeholder="Senha" required="" name="txtSenha">
                                <span toggle="#senha" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <?php echo form_error('txtSenha'); ?>
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

                        <?php echo form_close(); ?>
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
</body>

</html>