<form class="row g-3" id="editRombelForm" action="<?= base_url('/rombel/editsave') ?>" method="POST" enctype="multipart/form-data">

  <div class="col-12">
    <label for="guru">Guru</label>
    <select name="guru" id="guru" class="form-control" required>
      <option value="">-- Pilih Guru --</option>
      <?php foreach ($guru as $s): ?>
        <option value="<?= $s->id_guru ?>" <?= $love->id_guru == $s->id_guru ? 'selected' : '' ?>>
          <?= $s->nama ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Kelas -->
  <div class="col-12">
    <label for="id_kelas" class="form-label">Pilih Kelas:</label>
    <select class="form-control" name="id_kelas" id="id_kelas" required>
      <option value="">-- Pilih Kelas --</option>
      <?php foreach ($kelas as $k): ?>
        <option value="<?= $k->id_kelas ?>" <?= $k->id_kelas == $love->id_kelas ? 'selected' : '' ?>>
          Kelas <?= $k->nama_kelas ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-12">
    <label for="id_jurusan" class="form-label">Pilih Jurusan:</label>
    <select class="form-control" name="jurusan" id="jurusan" required>
      <option value="">-- Pilih Jurusan --</option>
      <?php foreach ($jurusan as $k): ?>
        <option value="<?= $k->id_jurusan ?>" <?= $k->id_jurusan == $love->id_jurusan ? 'selected' : '' ?>>
          Jurusan <?= $k->nama_jurusan ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Nama Rombel -->
  <div class="col-12">
    <label for="nama" class="form-label">Nama Rombel:</label>
    <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama_rombel ?>">
  </div>

  <!-- Hidden Input -->
<input type="hidden" name="id" value="<?= $love->id_rombel ?>">

  <div class="text-center">
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-secondary">Reset</button>
  </div>
</form>
