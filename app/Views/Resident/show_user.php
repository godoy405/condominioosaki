<?php echo form_open("residents/user/{$resident->user_id}"); ?>

<div class="row">
    <div class="col-md-12">
        <h4>Usuário do residente <?php echo $resident->name; ?></h4>
        
        <?php echo $this->include('Shared/_back_button'); ?>
        
        <?php if ($resident->user?->isBanned): ?>
            <button type="submit" name="unban" value="1" class="btn btn-success">LIBERAR ACESSO</button>
        <?php else: ?>
            <button type="submit" name="ban" value="1" class="btn btn-danger">BLOQUEAR ACESSO</button>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">E-mail de acesso</label>
            <input type="email" class="form-control" name="email" value="<?php echo old('email', $resident->user?->email); ?>">
        </div>
    </div>
</div>

<?php echo form_close(); ?>