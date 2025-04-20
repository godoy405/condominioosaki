<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title ?? 'Detalhes da Reserva'; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>
<style>
.button-group {
    margin-top: 1rem;
}
.button-group .btn {
    margin-right: 0.5rem;
}
.button-group form {
    display: inline-block;
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?php echo $title ?? 'Detalhes da Reserva'; ?></h6>
                <div class="button-group">
                    <a href="<?php echo route_to('reservations'); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-angle-double-left"></i>&nbsp;Voltar para lista
                    </a>
                    
                    <?php if(auth()->user()->inGroup('user')): ?>
                        <a href="<?php echo route_to('reservations.new'); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i>&nbsp;Nova Reserva
                        </a>

                        <?php echo form_open(
                            route_to('reservations.cancel', $reservation->code),
                            ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja cancelar esta reserva?");'],
                            ['_method' => 'PUT']
                        ); ?>
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        <?php echo form_close(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <?php if (isset($reservation) && $reservation !== null): ?>
                    <div class="mb-4">
                        <h4>Informações da Área</h4>
                        <p><strong>Nome da Área:</strong> <?php echo $reservation->area->name ?? 'Não definida'; ?></p>
                    </div>

                    <div class="mb-4">
                        <h4>Informações do Residente</h4>
                        <p><strong>Nome:</strong> <?php echo $reservation->resident->name ?? 'Não definido'; ?></p>
                        <p><strong>Apartamento:</strong> <?php echo $reservation->resident->apartment ?? 'Não definido'; ?></p>
                    </div>

                    <div class="mb-4">
                        <h4>Detalhes da Reserva</h4>
                        <p><strong>Código:</strong> <?php echo $reservation->code ?? 'N/A'; ?></p>
                        <p><strong>Data Desejada:</strong> <?php echo $reservation->desired_date ?? 'N/A'; ?></p>
                        <p><strong>Status:</strong> <?php echo $reservation->status(); ?></p>
                        <p><strong>Motivo do Status:</strong> <?php echo $reservation->reason_status ?? 'N/A'; ?></p>
                        <p><strong>Observações:</strong> <?php echo $reservation->notes ?? 'Nenhuma observação'; ?></p>
                        <?php if (isset($reservation->created_at)): ?>
                            <p><strong>Criado em:</strong> <?php echo $reservation->created_at->humanize(); ?></p>
                        <?php endif; ?>
                        <?php if (isset($reservation->updated_at)): ?>
                            <p><strong>Atualizado em:</strong> <?php echo $reservation->updated_at->humanize(); ?></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        Reserva não encontrada.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
<?php echo $this->endSection(); ?>