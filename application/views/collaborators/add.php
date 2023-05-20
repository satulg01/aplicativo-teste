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

    <?php echo form_open('colaboradores/add'); ?>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control bg-secondary text-light" id="nome" name="txtName" value="<?php echo set_value('txtName'); ?>">
            <?php echo form_error('txtName'); ?>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="txtType" id="type" class="form-control bg-secondary text-light" value="<?php echo set_value('txtType'); ?>">
                <option value="1">Usuário</option>
                <option value="2">Fornecedor</option>
            </select>
            <?php echo form_error('txtType'); ?>
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control bg-secondary text-light" value="<?php echo set_value('txtDocument'); ?>" id="cpf" format="cpf" name="txtDocument">
            <?php echo form_error('txtDocument'); ?>
        </div>

        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control bg-secondary text-light" value="<?php echo set_value('txtZipcode'); ?>" id="cep" format="cep" name="txtZipcode">
            <?php echo form_error('txtZipcode'); ?>
        </div>

        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control bg-secondary text-light" value="<?php echo set_value('txtCity'); ?>" id="cidade" name="txtCity">
            <?php echo form_error('txtCity'); ?>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control bg-secondary text-light" value="<?php echo set_value('txtState'); ?>" id="estado" name="txtState">
            <?php echo form_error('txtState'); ?>
        </div>

        <div class="mb-3">
            <label for="acesso" class="form-label">Acesso</label>
            <select class="form-control bg-secondary text-light" value="<?php echo set_value('txtAccess'); ?>" id="acesso" name="txtAccess">
                <option value="A">Admin</option>
                <option value="V">Vendedor</option>
            </select>
            <?php echo form_error('txtAccess'); ?>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="txtStatus" id="status" class="form-control bg-secondary text-light" value="<?php echo set_value('txtStatus'); ?>">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
            <?php echo form_error('txtStatus'); ?>
        </div>
        
        <button type="submit" class="btn btn-success" id="salvar">Salvar</button>
    <?php echo form_close(); ?>

</div>

<?php $this->load->view('components/html/footer'); ?>
