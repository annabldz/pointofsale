<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Pengaduan</h5>
    <form class="row g-3" action="<?= base_url('/pengaduan/inputsave') ?>" method="POST" enctype="multipart/form-data">
      
      <!-- <div class="col-12">
        <label for="file" class="form-label">Foto</label>
        <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
      </div> -->

      <div class="col-12">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" required>
      </div>

      <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
      </div>

      <div class="col-12">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
      </div>

      <div class="text-center">
        <input type="hidden" name="pengaduan" id="pengaduan">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>
    </form>
  </div>
</div>