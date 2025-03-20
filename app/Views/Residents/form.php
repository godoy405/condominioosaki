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
              <?php if ($resident->code === null): ?>
              <a href="<?php echo route_to('residents'); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-angle-double-left"></i>&nbsp;Listar residentes
              </a>
              <?php else: ?>
              <a href="<?php echo route_to('residents.show', $resident->code); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-angle-double-left"></i>&nbsp;Detalhes dos residentes
              </a>
              <?php endif; ?>
            </div>
            <div class="card-body">

            <?php if (session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo session('error'); ?>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session('success')): ?>
                <div class="alert alert-success">
                    <?php echo session('success'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open(
                    action: $route,
                    attributes: ['class' => 'd-inline', 'id' => 'form'],
                    hidden: $hidden ?? []
            ); ?>

                        <div class="mb-3">
                          <label for="name">Nome completo</label>
                          <input type="text" class="form-control <?php echo session('errors.name') ? 'is-invalid' : ''; ?>" required name="name" value="<?php echo old('name', $resident->name); ?>" id="name" placeholder="Nome completo" />
                          <?php if (session('errors.name')): ?>
                            <div class="invalid-feedback">
                                <?php echo session('errors.name'); ?>
                            </div>
                          <?php endif; ?>
                        </div>

                        <div class="mb-3">
                          <label for="mobile_phone">Telefone</label>
                          <input type="tel" class="form-control <?php echo session('errors.mobile_phone') ? 'is-invalid' : ''; ?>" required name="mobile_phone" value="<?php echo old('mobile_phone', $resident->mobile_phone); ?>" id="mobile_phone" placeholder="Telefone" />
                          <?php if (session('errors.mobile_phone')): ?>
                            <div class="invalid-feedback">
                                <?php echo session('errors.mobile_phone'); ?>
                            </div>
                          <?php endif; ?>
                        </div>

                        <div class="mb-3">
                          <label for="apartment">Apartamento</label>
                          <input type="text" class="form-control <?php echo session('errors.apartment') ? 'is-invalid' : ''; ?>" required name="apartment" value="<?php echo old('apartment', $resident->apartment); ?>" id="apartment" placeholder="Apartamento" />
                          <?php if (session('errors.apartment')): ?>
                            <div class="invalid-feedback">
                                <?php echo session('errors.apartment'); ?>
                            </div>
                          <?php endif; ?>
                        </div>

                        <button type="submit" id = "btnSubmit" class="btn btn-success">Salvar</button>
            <?php echo form_close(); ?>

            </div>
          </div>
        </div>
      </div>



<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>


<?php echo $this->endSection(); ?>




