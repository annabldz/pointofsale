<div id="content">

<div class="pagetitle">
  <h1>Edit User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit User</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit User</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/user/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="file" class="form-label">Foto</label>
              <input type="file" class="form-control" id="file" name="file" accept="img/" value="<?= $love->foto ?>" required><pre></pre>
              <img src="<?= base_url('assets/img/' . $love->foto) ?>" style="height: 100px; width: 100px;">
            </div>
            <div class="col-12">
              <label for="nama" class="form-label">Nama:</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama ?>">
            </div>

            <div class="col-12">
              <label for="nis" class="form-label">Username</label>
              <input type="text" class="form-control" id="nis" name="username" value="<?= $love->username ?>">
            </div>

            <div class="col-12">
              <label for="level" class="form-label">Level</label>
              <?php foreach ($level as $lvl): ?>
                <div class="form-check ">
                  <input class="form-check-input" type="radio" name="level" id="level<?= $lvl->id_level ?>"
                    value="<?= $lvl->id_level ?>" <?= ($love->level == $lvl->id_level) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="level<?= $lvl->id_level ?>"><?= $lvl->nama_level ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <input type="hidden" name="id" value="<?= $love->id_user ?>">


            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>