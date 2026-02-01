<div id="content">

<div class="pagetitle">
  <h1>Edit Ekskul</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Ekskul</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Ekskul</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/ekskul/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="nama" class="form-label">Nama Ekskul:</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama_ekskul ?>">
            </div>

            
            <div class="col-12">
              <label for="guru" class="form-label">Guru Instruktur:</label>
              <?php foreach ($guru as $lvl): ?>
                <div class="form-check ">
                  <input class="form-check-input" type="radio" name="guru" id="guru<?= $lvl->id_guru ?>"
                    value="<?= $lvl->id_guru ?>" <?= ($love->id_guru == $lvl->id_guru) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="guru<?= $lvl->id_guru ?>"><?= $lvl->nama ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <!-- <div class="col-12">
              <label for="mulai" class="form-label">Jam Mulai Ekskul:</label>
              <input type="time" class="form-control" id="mulai" name="mulai" value="<?= $love->jam_mulai ?>">
            </div>

            <div class="col-12">
              <label for="selesai" class="form-label">Jam Selesai Ekskul:</label>
              <input type="time" class="form-control" id="selesai" name="selesai" value="<?= $love->jam_selesai ?>">
            </div> -->


            <input type="hidden" name="id" value="<?= $love->id_ekskul ?>">


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