<!DOCTYPE html>
<html lang="pt-BR">
<?php
    $usuario = $this->session->logged_user;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satulg <?php echo (isset($title) ? "- " . $title : '') ?></title>
    
    <link href="<?= base_url('assets/css/') ?>bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Core.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Status.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/') ?>fonts.css" rel="stylesheet" crossorigin="anonymous">

    <script src="<?= base_url('assets/js/') ?>bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>popper.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery.mask.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>Core.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/Class/') ?>Ajax.js" crossorigin="anonymous"></script>

    <script>
        var site_url = '<?= site_url(''); ?>';

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



<body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="<?php echo site_url(''); ?>" class="nav-link px-2 link-secondary">Inicio</a></li>
                    <li><a href="<?php echo site_url('recebimentos'); ?>" class="nav-link px-2 link-secondary">Recebimentos</a></li>
                    <li><a href="<?php echo site_url('colaboradores'); ?>" class="nav-link px-2 link-secondary">Colaboradores</a></li>
                    <li><a href="<?php echo site_url('produtos'); ?>" class="nav-link px-2 link-secondary">Produtos</a></li>
                </ul>

                <div class="dropdown text-end col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <span href="#" class="d-block link-dark text-decoration-none"><?php echo $usuario["name"]; ?></span>
                </div>
                <div class="dropdown text-end col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/satulg.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo base_url('logout')?>">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </header>