
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Siswa</h5>
              <form class="row g-3" action="<?= base_url('/guru/inputsave')?>" method="POST" enctype="multipart/form-data" >
              <p><b>CATATAN!</b> Password default adalah <b>1.</b></p>  
              <div class="col-12">
                  <label for="file" class="form-label">Foto</label>
                  <input type="file" class="form-control" id="file" name="file" accept="img/" required>
                </div>
                <div class="col-12">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="col-12">
                  <label for="nik" class="form-label">NIK</label>
                  <input type="text" class="form-control" id="nik" name="nik" required>
                </div>
                <div class="col-12">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
           
                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>
