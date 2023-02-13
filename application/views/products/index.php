<?php $this->load->view('components/html/header'); ?>

<style>
    span.status-produto-1 {
        background: #0072B5;
        color: rgb(255, 255, 255);
        border: 1px solid #0042b5;
    }
    span.status.status-produto-1::before {
        content: 'Ativo';
    }

    span.status-produto-0 {
        background-color: crimson;
        color: white;
        border: 1px solid crimson;
    }
    span.status.status-produto-0::before {
        content: 'Inativo';
    }
</style>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url("/produtos/add"); ?>" class="btn btn-primary me-2">Adicionar</button>
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
                <th>Nome
                <th width="20%">Marca
                <th width="160" style="text-align:center;">Status
                <th width="160" style="text-align:center;">Ação
        </thead>
        <tbody>

            <?php if (!count($products)) : ?>

            <tr>
                <td colspan="5" align="center">Não há Produtos

            <?php endif ?>

            <?php foreach ($products as $product) : ?>

            <tr>
                <td><?php echo $product["id"]; ?>
                <td><?php echo $product["name"]; ?>
                <td><?php echo $product["brand"]; ?>
                <td align="center" valign="middle"><span class="status status-produto-<?php echo $product["status"]; ?>"></span>
                <td>

                
                <button tooltip="true" href="<?php echo site_url("/produtos/$product[id]/editar") ?>" data-bs-title="Editar produto" class="btn p-0 btn-primary edit-action"></button>
                
            <?php endforeach ?>
        </tbody>

    </table>
</div>


<?php $this->load->view('components/html/footer'); ?>
