<?php foreach ($siswa as $s) { ?>

<b><?= $s->nama ?></b>

<input type="hidden" name="id_pendaftaran[]" value="<?= $s->id_pendaftaran ?>">

<input type="number" name="nilai[]" class="form-control mb-2" required>

<?php } ?>
