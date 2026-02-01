<?php foreach ($siswa as $s) { ?>
<div class="mb-2">
  <b><?= $s->nama ?></b>

  <input type="hidden" name="id_pendaftaran[]" value="<?= $s->id_pendaftaran ?>">

  <select name="status[]" class="form-select">
    <option value="Hadir">Hadir</option>
    <option value="Izin">Izin</option>
    <option value="Sakit">Sakit</option>
    <option value="Alpha">Alpha</option>
  </select>
</div>
<?php } ?>
