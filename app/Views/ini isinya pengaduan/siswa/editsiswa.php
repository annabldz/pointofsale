<form action="<?= base_url('/siswa/editsave/' . $love->id_siswa) ?>" method="POST" enctype="multipart/form-data">

  <div class="col-12">
    <label for="file" class="form-label">Foto</label>
    <input type="file" class="form-control" id="file" name="file" accept="image/*">
    <small>*Kosongkan jika tidak ingin mengganti foto</small>
  </div>

  <div class="col-12">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" required value="<?= esc($love->nama) ?>">
  </div>

  <div class="col-12">
    <label for="nis" class="form-label">NIS</label>
    <input type="text" class="form-control" id="nis" name="nis" required value="<?= esc($love->nis) ?>">
  </div>

  <div class="col-12">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" required value="<?= esc($love->username) ?>">
  </div>

  <div class="col-12">
    <label for="rombel" class="form-label">Rombel</label>
    <select name="rombel" id="rombel" class="form-control" required>
      <option value="">-- Pilih Rombel --</option>
      <?php foreach ($rombel as $r): ?>
        <option value="<?= $r->id_rombel ?>" <?= ($love->id_rombel == $r->id_rombel) ? 'selected' : '' ?>>
          <?= esc($r->nama_kelas) ?> <?= esc($r->nama_jurusan) ?> <?= esc($r->nama_rombel) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="text-center">
    <input type="hidden" name="id" value="<?= $love->id_siswa ?>">
    <input type="hidden" name="id_user" value="<?= $love->id_user ?>">

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('/siswa') ?>" class="btn btn-secondary">Kembali</a>
  </div>
</form>