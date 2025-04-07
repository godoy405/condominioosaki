<?= $this->extend('Layout/dashboard') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?= $title ?></h4>
            </div>
            
            <div class="card-body">
                <?= form_open($route) ?>
                
                <div class="form-group">
                    <label for="area_id">Área</label>
                    <select name="area_id" id="area_id" class="form-control">
                        <?php foreach ($areas as $area): ?>
                            <option value="<?= $area->id ?>" <?= set_select('area_id', $area->id) ?>>
                                <?= $area->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="desired_date">Data desejada</label>
                    <input type="date" name="desired_date" id="desired_date" class="form-control" value="<?= set_value('desired_date') ?>">
                </div>

                <div class="form-group">
                    <label for="notes">Observações</label>
                    <textarea name="notes" id="notes" class="form-control"><?= set_value('notes') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Criar Nova Reserva
                </button>

                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>




