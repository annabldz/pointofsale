<div id="content">

<div class="pagetitle">
  <h1>Edit Jadwal</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Jadwal</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Jadwal</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/jadwal/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="ekskul" class="form-label">Nama Ekskul:</label>
              <?php foreach ($ekskul as $lvl): ?>
                <div class="form-check ">
                  <input class="form-check-input" type="radio" name="ekskul" id="ekskul<?= $lvl->id_ekskul ?>"
                    value="<?= $lvl->id_ekskul ?>" <?= ($love->id_ekskul == $lvl->id_ekskul) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="ekskul<?= $lvl->id_ekskul ?>"><?= $lvl->nama_ekskul ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="col-12">
              <label for="hari" class="form-label">Hari:</label>
              <input type="text" class="form-control" id="hari" name="hari" value="<?= $love->hari ?>">
            </div>

            
            <div class="col-12">
              <label for="mulai" class="form-label">Jam Mulai Ekskul:</label>
              <input type="time" class="form-control" id="mulai" name="mulai" value="<?= $love->jam_mulai ?>">
            </div>

            <div class="col-12">
              <label for="selesai" class="form-label">Jam Selesai Ekskul:</label>
              <input type="time" class="form-control" id="selesai" name="selesai" value="<?= $love->jam_selesai ?>">
            </div>

            <div class="form-check form-switch">
  <input class="form-check-input"
         type="checkbox"
         id="flexSwitchCheckChecked"
         name="aktif"
         value="1"
         <?= ($love->aktif == 1) ? 'checked' : '' ?>>
  <label class="form-check-label" for="flexSwitchCheckChecked">Jadwal Aktif</label>
</div>


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