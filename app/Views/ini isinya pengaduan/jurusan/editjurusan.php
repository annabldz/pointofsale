<div id="content">

<div class="pagetitle">
  <h1>Edit Jurusan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Jurusan</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Jurusan</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/jurusan/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="nama" class="form-label">Nama Jurusan:</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama_jurusan ?>">
            </div>

           
            <input type="hidden" name="id" value="<?= $love->id_jurusan ?>">


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