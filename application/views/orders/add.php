<?php $this->load->view('components/html/header'); ?>

<datalist id="list-produtos-id">
    <?php foreach ($this->product->getWhere([["status", "=", 1], ["name", "!=", ""]]) as $product) : ?>

    <option value="<?php echo $product["id"]; ?>" recordset="<?php echo $product["id"]; ?>"/>

    <?php endforeach ?>
</datalist>

<datalist id="list-produtos-nome">
    <?php foreach ($this->product->getWhere([["status", "=", 1], ["name", "!=", ""]]) as $product) : ?>

    <option value="<?php echo $product["name"]; ?>" recordset="<?php echo $product["id"]; ?>"/>

    <?php endforeach ?>
</datalist>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url('pedidos'); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>

<div class="container text-light">
    <h1>Adicionar pedido de compra</h1>

    <form action="" id="form-add">
        <div class="mb-3">
            <label for="fornecedor" class="form-label">Fornecedor</label>
            <select name="supplier_id" id="supplier" class="form-control bg-secondary text-light">
                <?php foreach ($this->collaborator->getWhere([["type", "=", 2], ["status", "=", 1]]) as $collaborator) : ?>

                    <option value="<?php echo $collaborator["id"]; ?>"><?php echo $collaborator["name"]; ?></option>
                    
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <textarea class="form-control bg-secondary text-light" id="observacao" name="observation"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control bg-secondary text-light">
                <option value="1">Ativo</option>
                <option value="2">Finalizado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Produtos</label>
            <table class="table text-light">
                <thead class="table-secondary">
                    <tr>
                        <th width="200">#
                        <th>Nome
                        <th width="15%">Quantidade
                        <th width="15%" style="text-align:center;">Valor
                        <th width="15%" style="text-align:center;">Valor Total
                        <th width="100" style="text-align:center;">Ação
                </thead>
                <tbody id="itens">
                    <tr class="produto-linha">
                        <td><input class="form-control bg-secondary text-light produtos-id" type="text" list="list-produtos-id"/>
                        <td><input class="form-control bg-secondary text-light produtos-nome" type="text" list="list-produtos-nome"/>
                        <td><input class="form-control bg-secondary text-light produtos-quantidade" type="text" format="decimal"/>
                        <td><input class="form-control bg-secondary text-light produtos-valor" type="text" format="money" value="0,00"/>
                        <td><input class="form-control bg-secondary text-light produtos-valor-total" type="text" format="money" readonly/>
                        <td><button type="button" tooltip="true" data-bs-title="Excluir item" class="btn p-0 btn-danger del-action"></button>
                </tbody>

            </table>

            <button type="button" class="btn btn-primary" id="adicionar-item">Adicionar Item</button>
        </div>
    </form>

    <button type="button" class="btn btn-success" id="salvar">Salvar</button>
</div>


<script>
    $("#salvar").click(function() {
        preloaderIniciar();

        var dados = $("#form-add").serializeArray();
        var erro = 0;

        let produtos = new Array();

        $(".produto-linha").each(function(index, element){
            let produto = new Object();

            produto["item_id"] = $(".produtos-id").eq(index).val();
            produto["quantity"] = toFloat($(".produtos-quantidade").eq(index).val());
            produto["value"] = toFloat($(".produtos-valor").eq(index).val());
            produto["value_final"] = toFloat($(".produtos-valor-total").eq(index).val());

            if( produto["item_id"] == "" || produto["quantity"] == "" ||  produto["value"] == "" ||  produto["value_final"] == "") {
                preloaderParar();
                erro++;
                return alertaErro("Preencha corretamente os produtos!");
            } else {
                produtos.push(produto);
            }
            
        });

        if(!produtos.length) {
            preloaderParar();
            return alertaErro("Selecione ao menos um item!");
        }

        if(erro) {
            return preloaderParar();
        }
        
        dados.push({name: "produtos", value: JSON.stringify(produtos)});


        Ajax.send_request("<?php echo site_url('/pedidos/add') ?>", dados,
            (resultado) => {
                console.log(resultado)
                alertaSucesso(resultado['mensagem']);
                setTimeout(() => {
                    location.href = "<?php echo site_url('/pedidos') ?>";
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

    $("#adicionar-item").click(function() {
        $("#itens").append(`
            <tr class="produto-linha">
                <td><input class="form-control bg-secondary text-light produtos-id" type="text" list="list-produtos-id"/>
                <td><input class="form-control bg-secondary text-light produtos-nome" type="text" list="list-produtos-nome"/>
                <td><input class="form-control bg-secondary text-light produtos-quantidade" type="text" format="decimal"/>
                <td><input class="form-control bg-secondary text-light produtos-valor" type="text" format="money" value="0,00"/>
                <td><input class="form-control bg-secondary text-light produtos-valor-total" type="text" format="money" readonly/>
                <td><button type="button" tooltip="true" data-bs-title="Excluir item" class="btn p-0 btn-danger del-action"></button>
        `);

        $('[format="money"]').mask("#.##0,00", {
            reverse: true
        });

        $('[format="decimal"]').mask("#.##0,00", {
            reverse: true
        });
        
        chargeTooltip();
    });

    $(document).on("change", ".produtos-id", function(){
        let index = $(".produtos-id").index($(this));

        if($(this).val() == "") {
            $(".produtos-nome").eq(index).val('');
        } else {
            let nome = $(`#${$(".produtos-nome").eq(index).attr("list")} option[recordset="${$(".produtos-id").eq(index).val()}"]`).val();
            $(".produtos-nome").eq(index).val(nome);
        }
    });

    $(document).on("change", ".produtos-nome", function(){
        let index = $(".produtos-nome").index($(this));

        if($(this).val() == "") {
            $(".produtos-id").eq(index).val('');
        } else {
            let id = $(`#${$(".produtos-nome").eq(index).attr("list")} option[value="${$(".produtos-nome").eq(index).val()}"]`).attr("recordset");
            $(".produtos-id").eq(index).val(id);
        }
    });

    $(document).on("change", ".produtos-quantidade", function(){
        let index = $(".produtos-quantidade").index($(this));

        if($(this).val() == "") {
            return;
        }

        let quantidade = toFloat($(".produtos-quantidade").eq(index).val());
        let valor = toFloat($(".produtos-valor").eq(index).val());

        let valorTotal = quantidade * valor;

        $(".produtos-valor-total").eq(index).val(setDinheiro(valorTotal));      
    });

    $(document).on("change", ".produtos-valor", function(){
        let index = $(".produtos-valor").index($(this));

        if($(this).val() == "") {
            return;
        }

        let quantidade = toFloat($(".produtos-quantidade").eq(index).val());
        let valor = toFloat($(".produtos-valor").eq(index).val());

        let valorTotal = quantidade * valor;

        $(".produtos-valor-total").eq(index).val(setDinheiro(valorTotal));      
    });
</script>


<?php $this->load->view('components/html/footer'); ?>
