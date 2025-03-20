<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?php echo $title; ?></h6>
                <div class="d-flex align-items-center">
                    <a href="<?php echo route_to('residents.show', $resident->code); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes do residente
                    </a>

                    <?php if ($showActionButton): ?>
                        <?php echo form_open(
                            action: route_to('residents.user.action', $resident->code),
                            attributes: ['class' => 'd-inline ms-2'],
                            hidden: ['_method' => 'PUT']
                        ); ?>

                        <?php $isBanned = $resident->user->isBanned(); ?>

                        <button type="submit" class="btn btn-<?php echo $isBanned ? 'info' : 'danger'; ?>">
                            <?php echo $isBanned ? 'LIBERAR ACESSO' : 'BLOQUEAR ACESSO'; ?>
                        </button>

                        <?php echo form_close(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
                ); ?>

                <div class="mb-3">
                    <label for="email">E-mail de acesso</label>
                    <input type="email" class="form-control <?php echo session('errors.email') ? 'is-invalid' : ''; ?>" required name="email" value="<?php echo old('email', $resident?->user?->email); ?>" id="email" placeholder="E-mail de acesso" />
                    <?php if (session('errors.email')): ?>
                        <div class="invalid-feedback">
                            <?php echo session('errors.email'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password">Senha <?php echo $resident?->user !== null ? '(opcional)' : ''; ?></label>
                    <input type="password" class="form-control <?php echo session('errors.password') ? 'is-invalid' : ''; ?>" <?php echo $resident?->user == null ? 'required' : ''; ?> name="password" id="password" placeholder="Senha de acesso" />
                    <?php if (session('errors.password')): ?>
                        <div class="invalid-feedback">
                            <?php echo session('errors.password'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password_confirm">Confirme a senha</label>
                    <input type="password" class="form-control <?php echo session('errors.password_confirm') ? 'is-invalid' : ''; ?>" name="password_confirm" id="password_confirm" placeholder="Confirme a senha" />
                    <?php if (session('errors.password_confirm')): ?>
                        <div class="invalid-feedback">
                            <?php echo session('errors.password_confirm'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" id="btnSubmit" class="btn btn-success">Salvar</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<?php echo $this->endSection(); ?>