<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Rombel</h5>
    <form class="row g-3" action="<?= base_url('/rombel/inputsave')?>" method="POST" enctype="multipart/form-data">

      <div class="col-12">
        <label for="guru">Guru</label>
        <select name="guru" id="guru" class="form-control" required>
          <option value="">-- Pilih Guru --</option>
          <?php foreach ($guru as $s): ?>
            <option value="<?= $s->id_guru ?>"><?= $s->nama ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12">
        <label for="kelas">Kelas</label>
        <select name="kelas" id="kelas" class="form-control" required>
          <option value="">-- Pilih Kelas --</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= $k->id_kelas ?>"><?= $k->nama_kelas ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12">
        <label for="jurusan">Jurusan</label>
        <select name="jurusan" id="jurusan" class="form-control" required>
          <option value="">-- Pilih Jurusan --</option>
          <?php foreach ($jurusan as $k): ?>
            <option value="<?= $k->id_jurusan ?>"><?= $k->nama_jurusan ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12">
        <label for="nama" class="form-label">Nama Rombel</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="text-center">
        <input type="hidden" name="user" id="user">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>

    </form>
  </div>
</div>
