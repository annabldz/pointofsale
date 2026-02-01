<div class="card">
  <div class="card-body">
    <h5 class="card-title">Edit Kesiswaan</h5>
    <form class="row g-3" action="<?= base_url('/kesiswaan/editsave') ?>" method="POST" enctype="multipart/form-data">
      
      <!-- Foto -->
      <div class="col-12">
        <label for="file" class="form-label">Foto</label>
        <input type="file" class="form-control" id="file" name="file" accept="img/*">
        <?php if (!empty($love->foto)) : ?>
          <img src="<?= base_url('assets/img/' . $love->foto) ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>

      <!-- Nama -->
      <div class="col-12">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama ?>" required>
      </div>

      <!-- NIS -->
      <div class="col-12">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" class="form-control" id="nik" name="nik" value="<?= $love->nik ?>" required>
      </div>

      <!-- Username -->
      <div class="col-12">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $love->username ?>" required>
      </div>


      <div class="text-center">
        <input type="hidden" name="id" id="id" value="<?= $love->id_kesiswaan ?>">
        <input type="hidden" name="id_user" value="<?= $love->id_user ?>">

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('/kesiswaan') ?>" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

