<?php $this->load->view('components/html/header'); ?>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url('colaboradores'); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>

<div class="container text-light">
    <h1>Adicionar colaborador</h1>

    <form action="" id="form-add">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control bg-secondary text-light" id="nome" name="name">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="type" id="type" class="form-control bg-secondary text-light">
                <option value="1">Usuário</option>
                <option value="2">Fornecedor</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control bg-secondary text-light" id="cpf" format="cpf" name="document">
        </div>

        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control bg-secondary text-light" id="cep" format="cep" name="zip_code">
        </div>

        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control bg-secondary text-light" id="cidade" name="city">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control bg-secondary text-light" id="estado" name="state">
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
    </form>

    <button type="button" class="btn btn-success" id="salvar">Salvar</button>
</div>


<script>
    $("#salvar").click(function() {
        var dados = $("#form-add").serializeArray();

        preloaderIniciar();

        Ajax.send_request("<?php echo site_url('/colaboradores/add') ?>", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                
                setTimeout(() => {
                    location.href = "<?php echo site_url('/colaboradores') ?>";
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();

                if(typeof error["responseJSON"] != "undefined") {
                    if(typeof error["responseJSON"]["mensagem"] != "undefined") {
                        alertaErro(error["responseJSON"]["mensagem"]);

                    }
                } else {
                    alertaErro("Erro ao inserir");
                }

                console.error(error);
            }, "progress-bar-excluir", "POST")

    });
</script>


<?php $this->load->view('components/html/footer'); ?>
