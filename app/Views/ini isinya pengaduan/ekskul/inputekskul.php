
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Ekskul</h5>
              <form class="row g-3" action="<?= base_url('/ekskul/inputsave')?>" method="POST" enctype="multipart/form-data" >
                
                <div class="col-12">
                  <label for="nama" class="form-label">Nama Ekskul</label>
                  <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                
                <div class="col-12">
                <label class="form-label">Guru Instruktur</label><br>
                <?php foreach ($guru as $lvl): ?>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="guru" id="guru<?= $lvl->id_guru ?>" value="<?= $lvl->id_guru ?>" required>
                    <label class="form-check-label" for="guru<?= $lvl->id_guru ?>"><?= $lvl->nama ?></label>
                    </div>
                <?php endforeach; ?>
                </div>

                <!-- <div class="col-12">
                  <label for="mulai" class="form-label">Jam Mulai Ekskul</label>
                  <input type="time" class="form-control" id="mulai" name="mulai" required>
                </div>

                <div class="col-12">
                  <label for="selesai" class="form-label">Jam Selesai Ekskul</label>
                  <input type="time" class="form-control" id="selesai" name="selesai" required>
                </div> -->

                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>


