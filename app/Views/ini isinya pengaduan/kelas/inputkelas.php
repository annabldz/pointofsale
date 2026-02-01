
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Kelas</h5>
              <form class="row g-3" action="<?= base_url('/kelas/inputsave')?>" method="POST" enctype="multipart/form-data" >

                <div class="col-12">
                  <label for="nama" class="form-label">Nama Kelas</label>
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


