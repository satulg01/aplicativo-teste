<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url($comeback); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <h1>Adicionar conta</h1>
    <div class="mb-3">
        <label for="conta-identificador" class="form-label">Identificador</label>
        <input type="text" class="form-control" id="conta-identificador" placeholder="Jubileu">
    </div>

    <div class="mb-3">
        <label for="conta-data" class="form-label">Data</label>
        <input type="date" class="form-control" id="conta-data" >
    </div>

    <label for="conta-valor" class="form-label">Valor</label>
    <div class="input-group mb-3">
        <span class="input-group-text">R$</span>
        <input type="text" class="form-control" format="money" id="conta-valor" placeholder="500,00">
    </div>

    <div class="mb-3">
        <label for="conta-recorrencia" class="form-label">Recorrencia</label>
        <input type="text" class="form-control" id="conta-recorrencia" value="0">
    </div>

    <button type="button" class="btn btn-success" id="conta-salvar">Salvar</button>
</div>


<script>
    $("#conta-salvar").click(function() {
        var dados = new Object();

        dados["valor"] = getDinheiroByElement($("#conta-valor"));
        dados["identificador"] = $("#conta-identificador").val();
        dados["data"] = getSqlDate($("#conta-data").val());
        dados["recorrencia"] = $("#conta-recorrencia").val();


        preloaderIniciar();

        Ajax.send_request(site_url + "recebimentos/add", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.href = site_url + "recebimentos";
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();
                alertaErro("Erro ao editar");
                console.error(error);
            }, "progress-bar-excluir", "POST")

    });
</script>