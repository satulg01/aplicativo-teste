<?php $this->load->view('components/html/header'); ?>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <?php if ($product["status"] == 0) : ?>

                <button type="button" id="reativar" class="btn btn-success me-2">Reativar</button>

                <?php endif ?>

                <button type="button" href="<?php echo site_url('produtos'); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <h1>Editar produto</h1>

    <form action="" id="form-edt">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="name" value="<?php echo $product["name"]; ?>" />
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="description"><?php echo $product["description"] ?></textarea>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="brand" value="<?php echo $product["brand"]; ?>">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>

        <input type="hidden" name="id" id="form-id" value="<?php echo $product["id"] ?>">
    </form>

    <?php if ($product["status"] == 1) : ?>

    <button type="button" class="btn btn-success" id="salvar">Salvar</button>

    <?php endif ?>

</div>


<script>
    window.onload = () => {
        $("#status").val(<?php echo $product["status"]; ?>);

        <?php if ($product["status"] != 1) : ?>

        $("input, textarea").attr("readonly", true);
        $("select").attr("disabled", true);

        <?php endif ?>
    }

    $("#salvar").click(function() {
        var dados = $("#form-edt").serializeArray();
        preloaderIniciar();

        Ajax.send_request(site_url + "produtos/editar", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);

                setTimeout(() => {
                    location.href = site_url + "produtos";
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

        Ajax.send_request("<?php echo site_url('/produtos/reativar') ?>", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                
                setTimeout(() => {
                    location.href = site_url + "produtos";
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
