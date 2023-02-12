<?php $this->load->view('components/html/header'); ?>

<style>
    span.status-colaborador-1 {
        background: rgb(4, 163, 15);
        color: rgb(255, 255, 255);
        border: 1px solid rgb(4, 131, 12);
    }
    span.status.status-colaborador-1::before {
        content: 'Ativo';
    }

    span.status-colaborador-0 {
        background-color: crimson;
        color: white;
        border: 1px solid crimson;
    }
    span.status.status-colaborador-0::before {
        content: 'Inativo';
    }
</style>

<header>
    <div class="px-3 py-2 border-bottom mb-3">
        <div class="container d-flex flex-wrap justify-content-center">
            <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search">
            </form>

            <div class="text-end">
                <button type="button" href="<?php echo site_url("/colaboradores/add"); ?>" class="btn btn-primary me-2">Adicionar</button>
                <button type="button" href="<?php echo site_url("/"); ?>" class="btn btn-light text-dark me-2">Voltar</button>
            </div>
        </div>
    </div>
</header>



<div class="container">
    <table class="table">
        <thead class="table-active">
            <tr>
                <th width="200">#
                <th>Nome
                <th width="15%">Cidade
                <th width="15%">CPF
                <th width="160" style="text-align:center;">Status
                <th width="160" style="text-align:center;">Ação
        </thead>
        <tbody>

            <?php if (!count($collaborators)) : ?>

            <tr>
                <td colspan="6" align="center">Não há colaboradores

            <?php endif ?>

            <?php foreach ($collaborators as $collaborator) : ?>

            <tr>
                <td><?php echo $collaborator["id"]; ?>
                <td><?php echo $collaborator["name"]; ?>
                <td><?php echo $collaborator["city"]; ?>
                <td><?php echo $collaborator["document"]; ?>
                <td align="center" valign="middle"><span class="status status-colaborador-<?php echo $collaborator["status"]; ?>"></span>
                <td>

                
                <button tooltip="true" href="<?php echo site_url("/colaboradores/$collaborator[id]/editar") ?>" data-bs-title="Editar colaborador" class="btn p-0 btn-primary edit-action"></button>
                
            <?php endforeach ?>
        </tbody>

    </table>
</div>


<?php $this->load->view('components/html/footer'); ?>
