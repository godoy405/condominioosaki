<?= $this->extend('Layout/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Minhas Reservas</h4>
                <a href="<?= url_to('resident.reservations.new') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Reserva
                </a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Área</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td><?= $reservation->area->name ?></td>
                                <td><?= date('d/m/Y', strtotime($reservation->date)) ?></td>
                                <td><?= $reservation->start_time ?> - <?= $reservation->end_time ?></td>
                                <td><?= $reservation->status ?></td>
                                <td>
                                    <?php if ($reservation->canBeCancelled()): ?>
                                    <a href="<?= url_to('resident.reservations.cancel', $reservation->code) ?>" 
                                       class="btn btn-sm btn-danger">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>