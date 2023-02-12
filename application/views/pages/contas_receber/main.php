<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url("/recebimentos/add"); ?>" class="btn btn-primary me-2">Adicionar</button>
                <button type="button" href="<?php echo site_url($comeback); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>



<div class="container">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th width="200">Data
                <th>Nome
                <th width="15%">Valor

                <th width="160">Status
                <th width="160">Ação
        </thead>
        <tbody>

            <?php if (!count($recebimentos)) : ?>

            <tr>
                <td colspan="5" align="center">Não há recebimentos

            <?php endif ?>

            <?php foreach ($recebimentos as $recebimento) : ?>

            <tr>
                <td><?php echo date("d/m/Y", strtotime($recebimento["data"])); ?>
                <td><?php echo $recebimento["identificador"]; ?>
                <td><span style="float:left;">R$</span><span style="float:right;"><?php echo number_format($recebimento["valor"], 2, ",", "."); ?></span>
                <td align="center"><span class="status status-recebimento-<?php echo $recebimento["status"]; ?>"></span>
                <td>

                <?php if ($recebimento["status"] == 1) : ?>

                        <button tooltip="true" data-bs-toggle="modal" recordset="<?php echo $recebimento["id"]; ?>" data-bs-target="#modal-editar" data-bs-title="Editar Recebimento" class="btn p-0 btn-primary edit-action recebimento-editar"></button>
                        <button tooltip="true" data-bs-toggle="modal" recordset="<?php echo $recebimento["id"]; ?>" data-bs-target="#modal-excluir" data-bs-title="Excluir Recebimento" class="btn p-0 btn-danger del-action recebimento-excluir"></button>
                        <button tooltip="true" data-bs-toggle="modal" recordset="<?php echo $recebimento["id"]; ?>" data-bs-target="#modal-pagar" data-bs-title="Pagar Recebimento" class="btn p-0 btn-success pay-action recebimento-pagar"></button>
                
                <?php else : ?>

                        <button tooltip="true" data-bs-toggle="modal" recordset="<?php echo $recebimento["id"]; ?>" data-bs-target="#modal-despagar" data-bs-title="Despagar Recebimento" class="btn p-0 btn-secondary pay-action recebimento-despagar"></button>
                
                <?php endif ?>

            <?php endforeach ?>
        </tbody>

    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-pagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Pagar recebimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja realmente pagar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="recebimento-pagar">Sim</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                <input type="hidden" id="recebimento-id-pagar" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-despagar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Despagar recebimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja realmente despagar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="recebimento-despagar">Sim</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                <input type="hidden" id="recebimento-id-despagar" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar recebimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recebimento-data" class="col-form-label">Data:</label>
                        <input type="text" class="form-control" format="date" id="recebimento-data">
                    </div>

                    <div class="mb-3">
                        <label for="recebimento-valor" class="col-form-label">Valor:</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" format="money" class="form-control" id="recebimento-valor">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="recebimento-identificador" class="col-form-label">Identificador:</label>
                        <input type="text" class="form-control" id="recebimento-identificador">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="recebimento-editar">Salvar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <input type="hidden" id="recebimento-id-editar" />
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-excluir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="progress" style="height: 2px;">
                <div class="progress-bar" id="progress-bar-excluir" role="progressbar" aria-label="Example 1px high" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir recebimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja realmente excluir?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="recebimento-excluir">Sim</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>
                <input type="hidden" id="recebimento-id-excluir" />
            </div>
        </div>
    </div>
</div>

<?php

$array_recebimentos = [];
foreach ($recebimentos as $recebimento) {
    $array_recebimentos[$recebimento["id"]] = $recebimento;
}
?>

<script>
    
    const RECEBIMENTOS = <?php echo json_encode($array_recebimentos); ?>;
    var url = site_url + "/recebimentos";

    $(document).on("click", ".recebimento-editar", function() {
        $("#recebimento-id-editar").val($(this).attr("recordset"));
        $("progress-bar-editar").css("width", 0);
        $("progress-bar-editar").attr("aria-valuenow", "0");

        let recebimento_atual = RECEBIMENTOS[$(this).attr("recordset")];

        if (typeof recebimento_atual == "undefined") {
            alertaErro("Erro ao obter dados");
            return;
        }

        $("#recebimento-valor").val(setDinheiro(recebimento_atual["valor"]));
        $("#recebimento-identificador").val(recebimento_atual["identificador"]);
        $("#recebimento-data").val(setDateFromTimestamp(recebimento_atual["data"]));
    });

    $("#recebimento-editar").click(function() {
        preloaderIniciar();

        var camposObrigatorios = new Array();
        camposObrigatorios.push("recebimento-data");
        camposObrigatorios.push("recebimento-valor");
        camposObrigatorios.push("recebimento-identificador");

        if (verificaObrigatoriedade(camposObrigatorios)) {
            return alertaErro(`Existem campos para serem preenchidos!`);
        }

        var dados = new Object();
        dados["recordset"] = $("#recebimento-id-editar").val();
        dados["valor"] = $("#recebimento-valor").val();
        dados["identificador"] = $("#recebimento-identificador").val();
        dados["data"] = getSqlDate($("#recebimento-data").val());

        Ajax.send_request(url, dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.reload();
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();
                alertaErro("Erro ao editar");
                console.error(error);
            }, "progressodelete", "PUT")
    });



    $(document).on("click", ".recebimento-excluir", function() {
        $("#recebimento-id-excluir").val($(this).attr("recordset"));
        $("#progress-bar-excluir").css("width", '0%');
        $("#progress-bar-excluir").attr("aria-valuenow", "0");
    });

    $("#recebimento-excluir").click(function() {
        var dados = new Object();
        dados["recordset"] = $("#recebimento-id-excluir").val();


        Ajax.send_request(url, dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.reload();
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();
                alertaErro("Erro ao editar");
                console.error(error);
            }, "progress-bar-excluir", "DELETE")
    });



    $(document).on("click", ".recebimento-pagar", function() {
        $("#recebimento-id-pagar").val($(this).attr("recordset"));
    });

    $("#recebimento-pagar").click(function() {
        preloaderIniciar();

        var dados = new Object();
        dados["recordset"] = $("#recebimento-id-pagar").val();

        Ajax.send_request(url + "/pay", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.reload();
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();
                alertaErro("Erro ao editar");
                console.error(error);
            }, "progressodelete", "PUT")
    });

    $(document).on("click", ".recebimento-despagar", function() {
        $("#recebimento-id-despagar").val($(this).attr("recordset"));
    });

    $("#recebimento-despagar").click(function() {
        preloaderIniciar();

        var dados = new Object();
        dados["recordset"] = $("#recebimento-id-despagar").val();

        Ajax.send_request(url + "/unpay", dados,
            (resultado) => {
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.reload();
                }, TIME_UPDATE);
            },
            (error) => {
                preloaderParar();
                alertaErro("Erro ao editar");
                console.error(error);
            }, "progressodelete", "PUT")
    });
</script>