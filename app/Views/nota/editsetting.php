<div id="content">

<div class="pagetitle">
  <h1>Edit Nota Setting</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Nota Setting</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Nota Setting</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/nota/editsettingsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="file" class="form-label">Foto</label>
              <input type="file" class="form-control" id="file" name="file" accept="img/" value="<?= $love->logo ?>" ><pre></pre>
              <img src="<?= base_url('assets/img/' . $love->logo) ?>" style="height: 100px; width: 100px;">
            </div>
            <div class="col-12">
              <label for="title" class="form-label">Title:</label>
              <input type="text" class="form-control" id="title" name="title" value="<?= $love->title ?>">
            </div>

            <div class="col-12">
              <label for="notelp" class="form-label">No Telp</label>
              <input type="text" class="form-control" id="notelp" name="notelp" value="<?= $love->notelp ?>">
            </div>

            <div class="col-12">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $love->alamat ?>">
            </div>

            <input type="hidden" name="id" value="<?= $love->id_notset ?>">


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