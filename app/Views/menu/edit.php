<div id="content">

<div class="pagetitle">
  <h1>Edit Menu</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Menu</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Menu</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/menu/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="nama" class="form-label">Nama Menu:</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama_menu ?>">
            </div>

            <div class="col-12">
              <label for="url" class="form-label">Url:</label>
              <input type="text" class="form-control" id="url" name="url" value="<?= $love->url ?>">
            </div>

            <div class="col-12">
              <label for="icon" class="form-label">Icons:</label>
              <input type="text" class="form-control" id="icon" name="icon" value="<?= $love->icon ?>">
            </div>

           <div class="col-12">
    <label for="parent_id" class="form-label">Parent Menu</label>
    <select name="parent_id" id="parent_id" class="form-select">
        <option value="">-- Menu Utama --</option>

        <?php foreach ($parent_menu as $pm): ?>
            <option value="<?= $pm['id_menu']; ?>" 
                <?= ($love->parent_id ?? null) == $pm['id_menu'] ? 'selected' : '' ?>>
                <?= $pm['nama_menu']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


           
            <input type="hidden" name="id" value="<?= $love->id_menu ?>">


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