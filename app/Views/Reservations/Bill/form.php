<?php
// cSpell:disable
use App\Cells\Bills\FormInputsCell;

 echo $this->extend('Layouts/main'); ?>

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
                <a href="<?php echo route_to('reservations.index') ?>" class="btn btn-secondary mb-3">
                    « DETALHES DO RESIDENTE
                </a>
            </div>
            <div class="card-body">
                <?php echo form_open(route_to('reservations.bills.create', $reservation->code)); ?>

                <div class="mb-3">
                    <strong>Residente:</strong> <?php echo $reservation->resident->name ?? '?' ?>
                </div>

                <div class="mb-3">
                    <strong>Área:</strong> <?php echo $reservation->area->name ?? '?' ?>
                </div>

                <?php echo view_cell(library: FormInputsCell::class,params: ['bill' => $reservation?->bill]) ?>

                <div class="form-group">
                    <label for="amount">Valor da cobrança</label>
                    <input type="text" name="amount" class="form-control" value="<?php echo old('amount') ?>">
                </div>

                <div class="form-group">
                    <label for="due_date">Data de vencimento</label>
                    <input type="date" name="due_date" class="form-control" value="<?php echo old('due_date') ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status do pagamento</label>
                    <select name="status" class="form-control">
                        <option value="">--- Escolha ---</option>
                        <!-- Adicione suas opções de status aqui -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Observações da cobrança</label>
                    <textarea name="notes" class="form-control"><?php echo old('notes') ?></textarea>
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