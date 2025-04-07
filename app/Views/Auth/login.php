<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>
Login
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Login</h4>
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

                    <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sindico-tab" data-bs-toggle="tab" data-bs-target="#sindico" type="button" role="tab" aria-controls="sindico" aria-selected="true">
                                Síndico
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="residente-tab" data-bs-toggle="tab" data-bs-target="#residente" type="button" role="tab" aria-controls="residente" aria-selected="false">
                                Residente
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="loginTabsContent">
                        <!-- Login Síndico -->
                        <div class="tab-pane fade show active" id="sindico" role="tabpanel" aria-labelledby="sindico-tab">
                            <?php echo form_open('login'); ?>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Entrar como Síndico</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>

                        <!-- Login Residente -->
                        <div class="tab-pane fade" id="residente" role="tabpanel" aria-labelledby="residente-tab">
                            <?php echo form_open('resident/login'); ?>
                                <div class="mb-3">
                                    <label for="resident_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="resident_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="resident_password" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="resident_password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Entrar como Residente</button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const triggerTabList = document.querySelectorAll('#loginTabs button');
    triggerTabList.forEach(triggerEl => {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', event => {
            event.preventDefault();
            tabTrigger.show();
        });
    });
});
</script>
<?php echo $this->endSection(); ?> 