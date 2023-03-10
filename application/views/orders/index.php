<?php $this->load->view('components/html/header'); ?>

<style>
    span.status-pedido-1 {
        background: #0072B5;
        color: rgb(255, 255, 255);
        border: 1px solid #0042b5;
    }
    span.status.status-pedido-1::before {
        content: 'Ativo';
    }

    span.status-pedido-2 {
        background-color: #04a30f;
        color: white;
        border: 1px solid #038c0c;
    }
    span.status.status-pedido-2::before {
        content: 'Finalizado';
    }
</style>

<?php
    $array_collaborators = $this->collaborator->getWhere([]);

    $collaborators = array();
    foreach ($array_collaborators as $x => $collaborator) {
        $collaborators[$collaborator["id"]] = $collaborator;
    }
?>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url("/pedidos/add"); ?>" class="btn btn-primary me-2">Adicionar</button>
                <button type="button" href="<?php echo site_url("/"); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>



<div class="container">
    <table class="table text-light">
        <thead class="table-secondary">
            <tr>
                <th width="200">#
                <th width="200">Data
                <th>Fornecedor
                <th width="130" style="text-align:center;">Valor
                <th width="200" style="text-align:center;">Status
                <th width="160" style="text-align:center;">Ação
        </thead>
        <tbody>

            <?php if (!count($orders)) : ?>

            <tr>
                <td colspan="6" align="center">Não há pedidos

            <?php endif ?>

            <?php foreach ($orders as $order) : ?>

            <tr>
                <td><?php echo $order["id"]; ?>
                <td><?php echo date("d/m/Y", strtotime($order["date_sale"])); ?>
                <td><?php echo $collaborators[$order["supplier_id"]]["name"]; ?>
                <td><span style="float: left">R$</span><span style="float: right"><?php echo number_format($order["value"], 2, ",", "."); ?></span>
                <td align="center" valign="middle"><span class="status status-pedido-<?php echo $order["status"]; ?>"></span>
                <td>

                
                <button tooltip="true" href="<?php echo site_url("/pedidos/$order[id]/editar") ?>" data-bs-title="Editar pedido" class="btn p-0 btn-primary edit-action"></button>
                
            <?php endforeach ?>
        </tbody>

    </table>
</div>


<?php $this->load->view('components/html/footer'); ?>
