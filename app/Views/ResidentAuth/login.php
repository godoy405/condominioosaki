<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>
Login de Residente
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Login de Residente</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo session('error'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success">
                            <?php echo session('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('resident/login'); ?>
                        <div class="mb-3">
                            <label for="mobile_phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="mobile_phone" name="mobile_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?> 