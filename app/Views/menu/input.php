
<div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Menu</h5>
              <form class="row g-3" action="<?= base_url('/menu/inputsave')?>" method="POST" enctype="multipart/form-data" >

                <div class="col-12">
                  <label for="nama" class="form-label">Nama Menu</label>
                  <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="col-12">
                  <label for="url" class="form-label">URL</label>
                  <input type="text" class="form-control" id="url" name="url" required>
                </div>

                <div class="col-12">
                  <label for="icon" class="form-label">Icons</label>
                  <input type="text" class="form-control" id="icon" name="icon" required>
                </div>

                <div class="col-12">
                <label for="parent_id" class="form-label">Parent Menu</label>
                <select name="parent_id" id="parent_id" class="form-select">
                    <option value="">-- Menu Utama --</option>

                    <?php foreach ($parent_menu as $pm): ?>
                    <option value="<?= $pm['id_menu']; ?>">
                        <?= $pm['nama_menu']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                </div>


                <div class="text-center">
                  <input type="hidden" name="user" id="user">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>

            </div>
          </div>


