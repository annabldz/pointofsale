
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Nota Setting</h5>
              <form class="row g-3" action="<?= base_url('/nota/inputsettingsave')?>" method="POST" enctype="multipart/form-data" >
                <div class="col-12">
                  <label for="file" class="form-label">Foto</label>
                  <input type="file" class="form-control" id="file" name="file" accept="img/" required>
                </div>
                <div class="col-12">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-12">
                  <label for="notelp" class="form-label">No Telp</label>
                  <input type="text" class="form-control" id="notelp" name="notelp" required>
                </div>

                <div class="col-12">
                  <label for="alamat" class="form-label">Alamat</label>
                  <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>

                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>


