

    <div class="pagetitle">
      <h1>Tabel Pengaduan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Data Pengaduan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <pre></pre>
              <a href="<?= base_url('/pengaduan/input') ?>" class="btn btn-success mb-3 text-white">Input Pengaduan</a>

              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Status</th>   
                    <?php
          if (session()->get('level')==1 || session()->get('level')==3 ){ ?>               
                    <th scope="col">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $ms = 1; foreach ($love as $key => $value) { ?>
                    <tr>
                      <td><?= $ms++ ?></td>
                    
                      <td><?= $value->nama ?></td>
                      <td><?= $value->judul ?></td>
                      <td><?= $value->status ?></td>
                    <?php
          if (session()->get('level')==1 || session()->get('level')==3 ){ ?>
                      <td>
  <button 
    class="btn btn-info btn-lihat"
    data-id="<?= $value->id_pengaduan ?>"
    data-judul="<?= $value->judul ?>"
    data-deskripsi="<?= $value->deskripsi ?>"
    data-tanggal="<?= date('d-m-Y', strtotime($value->tanggal)) ?>"
  >
    <i class="bi bi-eye"></i> Lihat
  </button>
</td>
<?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

              <div class="modal fade" id="modalPengaduan" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Pengaduan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="pengaduan_id">

        <div class="mb-3">
          <label class="fw-bold">Judul</label>
          <p id="detailJudul"></p>
        </div>

        <div class="mb-3">
          <label class="fw-bold">Deskripsi</label>
          <p id="detailDeskripsi"></p>
        </div>

        <div class="mb-3">
          <label class="fw-bold">Tanggal</label>
          <p id="detailTanggal"></p>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-danger" id="btnTolak">Tolak</button>
        <button class="btn btn-success" id="btnSetujui">Setujui</button>
      </div>

    </div>
  </div>
</div>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

 <script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = new bootstrap.Modal(document.getElementById('modalPengaduan'));

  document.querySelectorAll('.btn-lihat').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('pengaduan_id').value = this.dataset.id;
      document.getElementById('detailJudul').innerText = this.dataset.judul;
      document.getElementById('detailDeskripsi').innerText = this.dataset.deskripsi;
      document.getElementById('detailTanggal').innerText = this.dataset.tanggal;

      modal.show();
    });
  });

  document.getElementById('btnSetujui').addEventListener('click', function () {
    const id = document.getElementById('pengaduan_id').value;
    window.location.href = `<?= base_url('/pengaduan/setujui/') ?>` + id;
  });

  document.getElementById('btnTolak').addEventListener('click', function () {
    const id = document.getElementById('pengaduan_id').value;
    window.location.href = `<?= base_url('/pengaduan/tolak/') ?>` + id;
  });
});
</script>
