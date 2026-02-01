
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input User</h5>
              <form class="row g-3" action="<?= base_url('/user/inputsave')?>" method="POST" enctype="multipart/form-data" >
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
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <!-- <div class="col-12">
                     <label for="username" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div> -->
                <div class="col-12">
                <label class="form-label">Level</label><br>
                <?php foreach ($level as $lvl): ?>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="level" id="level<?= $lvl->id_level ?>" value="<?= $lvl->id_level ?>" required>
                    <label class="form-check-label" for="level<?= $lvl->id_level ?>"><?= $lvl->nama_level ?></label>
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


