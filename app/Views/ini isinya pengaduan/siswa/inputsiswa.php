<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Siswa</h5>
    <form class="row g-3" action="<?= base_url('/siswa/inputsave') ?>" method="POST" enctype="multipart/form-data">
      <p><b>CATATAN!</b> Password default adalah <b>1.</b></p>
      
      <div class="col-12">
        <label for="file" class="form-label">Foto</label>
        <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
      </div>

      <div class="col-12">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="col-12">
        <label for="nis" class="form-label">NIS</label>
        <input type="text" class="form-control" id="nis" name="nis" required>
      </div>

      <div class="col-12">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="col-12">
        <label for="rombel" class="form-label">Rombel</label>
        <select name="rombel" id="rombel" class="form-control" required>
          <option value="">-- Pilih Rombel --</option>
          <?php foreach ($rombel as $s): ?>
            <option value="<?= $s->id_rombel ?>"><?= $s->nama_kelas ?> <?= $s->nama_jurusan ?> <?= $s->nama_rombel ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="text-center">
        <input type="hidden" name="user" id="user">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>