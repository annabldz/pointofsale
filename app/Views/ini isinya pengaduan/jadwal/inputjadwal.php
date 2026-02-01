
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Jadwal</h5>
              <form class="row g-3" action="<?= base_url('/jadwal/inputsave')?>" method="POST" enctype="multipart/form-data" >
                
                <div class="col-12">
                <label class="form-label">Nama Ekskul</label><br>
                <?php foreach ($ekskul as $lvl): ?>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="ekskul" id="ekskul<?= $lvl->id_ekskul ?>" value="<?= $lvl->id_ekskul ?>" required>
                    <label class="form-check-label" for="ekskul<?= $lvl->id_ekskul ?>"><?= $lvl->nama_ekskul ?></label>
                    </div>
                <?php endforeach; ?>
                </div>

                <div class="col-12">
                  <label for="hari" class="form-label">Hari</label>
                  <input type="text" class="form-control" id="hari" name="hari" required>
                </div>

                <div class="col-12">
                  <label for="mulai" class="form-label">Jam Mulai Ekskul</label>
                  <input type="time" class="form-control" id="mulai" name="mulai" required>
                </div>

                <div class="col-12">
                  <label for="selesai" class="form-label">Jam Selesai Ekskul</label>
                  <input type="time" class="form-control" id="selesai" name="selesai" required>
                </div>

                <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="aktif" value="1">

                      <label class="form-check-label" for="flexSwitchCheckChecked">Jadwal Aktif</label>
                    </div>

                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>


