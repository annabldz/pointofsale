
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Pendaftaran</h5>
              <form class="row g-3" action="<?= base_url('/pendaftaran/inputsave')?>" method="POST" enctype="multipart/form-data" >
                
                <div class="col-12">
                <label class="form-label">Pilih Ekskul</label><br>
                <?php foreach ($jadwal as $lvl): ?>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="jadwal" id="jadwal<?= $lvl->id_jadwal ?>" value="<?= $lvl->id_jadwal ?>" required>
                    <label class="form-check-label" for="jadwal<?= $lvl->id_jadwal ?>"><?= $lvl->nama_ekskul ?> - <?= $lvl->hari ?> (<?= $lvl->jam_mulai ?> - <?= $lvl->jam_selesai ?>)</label>
                    </div>
                <?php endforeach; ?>
                </div>

                
          
                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>


