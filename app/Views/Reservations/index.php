<?= $this->extend('Layout/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>LISTAGEM DE RESERVAS</h4>
                <a href="<?= site_url('resident/reservations/new') ?>" class="btn btn-success">
                    + NOVA
                </a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Área</th>
                                <th>Status</th>
                                <th>Criado</th>
                                <th>Atualizado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reservations)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum dado disponível na tabela</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>




