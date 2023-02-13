<?php $this->load->view('components/html/header'); ?>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <?php if ($collaborator["status"] == 0) : ?>

                <button type="button" id="reativar" class="btn btn-success me-2">Reativar</button>

                <?php endif ?>

                <button type="button" href="<?php echo site_url('colaboradores'); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>

<div class="container text-light">
    <h1>Editar colaborador</h1>

    <form action="" id="form-edt">
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control bg-secondary text-light" id="nome" name="name" value="<?php echo $collaborator["name"]; ?>" />
        </div>
        
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="type" id="tipo" class="form-control bg-secondary text-light">
                <option value="1">Usuário</option>
                <option value="2">Fornecedor</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control bg-secondary text-light" id="cpf" format="cpf" name="document" value="<?php echo $collaborator["document"] ?>" />
        </div>

        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control bg-secondary text-light" id="cep" format="cep" name="zip_code" value="<?php echo $collaborator["zip_code"] ?>" />
        </div>

        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control bg-secondary text-light" id="cidade" name="city" value="<?php echo $collaborator["city"] ?>" />
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control bg-secondary text-light" id="estado" name="state" value="<?php echo $collaborator["state"] ?>" />
        </div>

        <div class="mb-3">
            <label for="acesso" class="form-label">Acesso</label>
            <select class="form-control bg-secondary text-light" id="acesso" name="access">
                <option value="A">Admin</option>
                <option value="V">Vendedor</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control bg-secondary text-light">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>

        <input type="hidden" name="id" id="form-id" value="<?php echo $collaborator["id"] ?>">
    </form>

    <?php if ($collaborator["status"] == 1) : ?>

    <button type="button" class="btn btn-success" id="salvar">Salvar</button>

    <?php endif ?>

</div>


<script>
    window.onload = () => {
        $("#status").val(<?php echo $collaborator["status"]; ?>);
        $("#tipo").val(<?php echo $collaborator["type"]; ?>);
        $("#acesso").val('<?php echo $collaborator["access"]; ?>');

        <?php if ($collaborator["status"] != 1) : ?>

        $("input, textarea").attr("readonly", true);
        $("select").attr("disabled", true);

        <?php endif ?>
    }

    $("#salvar").click(function() {
        var dados = $("#form-edt").serializeArray();
        preloaderIniciar();

        Ajax.send_request(site_url + "colaboradores/editar", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);

                setTimeout(() => {
                    location.href = site_url + "colaboradores";
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();

                if(typeof error["responseJSON"] != "undefined") {
                    if(typeof error["responseJSON"]["mensagem"] != "undefined") {
                        alertaErro(error["responseJSON"]["mensagem"]);

                    }
                } else {
                    alertaErro("Erro ao editar");
                }

                console.error(error);
            }, "progress-bar-excluir", "put")

    });



    $("#reativar").click(function() {
        var dados = {
            id: $("#form-id").val()
        }
        preloaderIniciar();

        Ajax.send_request("<?php echo site_url('/colaboradores/reativar') ?>", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                
                setTimeout(() => {
                    location.href = site_url + "colaboradores";
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();

                if(typeof error["responseJSON"] != "undefined") {
                    if(typeof error["responseJSON"]["mensagem"] != "undefined") {
                        alertaErro(error["responseJSON"]["mensagem"]);

                    }
                } else {
                    alertaErro("Erro ao editar");
                }

                console.error(error);
            }, "progress-bar-excluir", "put")

    });
</script>


<?php $this->load->view('components/html/footer'); ?>
