<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FC <?php echo (isset($title) ? "- " . $title : '') ?></title>
    
    <link href="<?= base_url('assets/css/') ?>bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Core.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/css/') ?>Status.css" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= base_url('assets/') ?>fonts.css" rel="stylesheet" crossorigin="anonymous">

    <script src="<?= base_url('assets/js/') ?>bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>popper.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>jquery.mask.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/') ?>Core.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/Class/') ?>Ajax.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FONT AWESOME -->
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

    <script>
        var site_url = '<?= site_url(''); ?>';

        window.onload = () => {
            <?php if($this->session->danger): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: '<?php echo $this->session->danger; ?>',
                })
            <?php endif ?>

            <?php if($this->session->success): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: '<?php echo $this->session->success; ?>',
                })
            <?php endif ?>

            <?php if($this->session->info): ?>
                Swal.fire({
                    icon: 'info',
                    title: 'Informação!',
                    text: '<?php echo $this->session->info; ?>',
                })
            <?php endif ?>
        }
    </script>
    
</head>



<body class="bg-dark"> 
    <header class="p-3 bg-dark text-white border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <!-- SMART ESSE APARECE -->
                <a href="/"
                    class="col-11 col-md-2 d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="<?php echo base_url('/assets/img/logo.png'); ?>" alt="Logo Sinpro" width="100">
                </a>

                <ul class="d-none d-md-flex col-md-7 nav col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="<?php echo site_url(''); ?>" class="nav-link px-2 link-secondary text-light">Inicio</a></li>
                    <?php if ($user["access"] == "A") : ?> <li><a href="<?php echo site_url('colaboradores'); ?>" class="nav-link px-2 link-secondary text-light">Colaboradores</a></li> <?php endif ?>
                    <?php if ($user["access"] == "A") : ?> <li><a href="<?php echo site_url('produtos'); ?>" class="nav-link px-2 link-secondary text-light">Produtos</a></li> <?php endif ?>
                    <li><a href="<?php echo site_url('pedidos'); ?>" class="nav-link px-2 link-secondary text-light">Pedidos de Compra</a></li>
                </ul>

                <!-- SMART ESSE APARECE -->
                <button class="col-1 d-md-none btn text-white" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvas" role="button">
                    <i class="fa fa-bars" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
                </button>

                <div class="col-md-3 d-none d-md-flex col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex align-items-center justify-content-center justify-content-lg-start">
                    <div class="dropdown text-end d-inline-block mb-3 mb-lg-0 me-lg-3">
                        <span href="#" class="d-block link-light text-decoration-none"><?php echo $user["name"]; ?></span>
                    </div>
    
                    <div class="dropdown text-end d-inline-block mb-3 mb-lg-0 me-lg-3">
                        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small  text-light" style="">
                            <!-- <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li> -->
                            <li><a class="dropdown-item" href="<?php echo base_url('logout')?>">Sair</a></li>
                        </ul>
                    </div>
                </div>

                <div class="text-end">
                </div>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start w-25 bg-dark" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <!-- SMART ESSE APARECE -->
            <a href="/" class="offcanvas-title text-white text-decoration-none">
                <img src="<?php echo base_url('/assets/img/logo.png'); ?>" alt="Logo Financial Controller" width="80">
            </a>

        </div>

        <div class="offcanvas-body px-0 d-flex flex-wrap align-content-between justify-content-center">
            <ul class="nav w-100 nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start justify-content-center"
                id="menu">
                <li class="nav-item border-bottom border-bottom-sm-0 mb-3 mb-sm-0">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-home"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                    </a>
                </li>
                <li class="nav-item border-bottom border-bottom-sm-0 mb-3 mb-sm-0">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-users"></i><span class="ms-1 d-none d-sm-inline">Sindicato</span>
                    </a>
                </li>
                <li class="nav-item border-bottom border-bottom-sm-0 mb-3 mb-sm-0">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-users"></i><span class="ms-1 d-none d-sm-inline">Convenções</span>
                    </a>
                </li>
                <li class="nav-item border-bottom border-bottom-sm-0 mb-3 mb-sm-0">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-newspaper"></i><span
                            class="ms-1 d-none d-sm-inline">Notícias</span>
                    </a>
                </li>
                <li class="nav-item border-bottom border-bottom-sm-0 mb-3 mb-sm-0">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-user"></i><span class="ms-1 d-none d-sm-inline">Contato</span>
                    </a>
                </li>
            </ul>

            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
    </div>