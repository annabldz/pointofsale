

    <div class="pagetitle">
      <h1>Tabel Nilai</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Data Nilai</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger">
  <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success">
  <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>
          <?php foreach ($ekskul_saya as $e) { ?>
<div class="card mb-2">
  <div class="card-body">
<pre></pre>
    <h5><?= $e->nama_ekskul ?></h5>
    <small>Instruktur: <?= $e->nama ?></small>

    <!-- tombol buka tanggal -->
    <div class="accordion mt-2" id="ekskul<?= $e->id_ekskul ?>">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tanggal<?= $e->id_ekskul ?>">
            Lihat / Input Nilai
          </button>
        </h2>

        <div id="tanggal<?= $e->id_ekskul ?>" class="accordion-collapse collapse">

          <div class="accordion-body">

            <!-- tombol tambah absensi (MODAL) -->
         <button class="btn btn-primary btn-sm"
  onclick="openInputNilai(<?= $e->id_ekskul ?>)"
  data-bs-toggle="modal"
  data-bs-target="#modalInputNilai">
  Input Nilai
</button>
<button class="btn btn-success btn-sm"
  onclick="openLihatNilai(<?= $e->id_ekskul ?>)"
  data-bs-toggle="modal"
  data-bs-target="#modalLihatNilai">
  Lihat Nilai
</button>
<a href="<?= base_url('nilai/cetak/'.$e->id_ekskul) ?>" 
   class="btn btn-danger btn-sm" 
   target="_blank">
   Cetak PDF Nilai
</a>

            <hr>

            <!-- daftar tanggal absensi -->
           

          </div>

        </div>
      </div>
    </div>

  </div>
</div>
<?php } ?>
<div class="modal fade" id="modalInputNilai">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Input Nilai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" action="<?= base_url('nilai/simpan') ?>">

        <div class="modal-body">

          <input type="hidden" name="id_ekskul" id="id_ekskul">

      
          <hr>

          <!-- contoh looping siswa -->
      <div id="listNilai"></div>


        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>
<div class="modal fade" id="modalLihatNilai">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Data Nilai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="bodyLihatNilai">
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalDetailAbsensi">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Absensi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="bodyDetailAbsensi">
        <!-- isi tabel siswa hadir/izin/sakit/alpha -->
      </div>

    </div>
  </div>
</div>


        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <script>


function openDetailAbsensi(id_absensi) {
  fetch('<?= base_url("absensi/detail") ?>/' + id_absensi)
    .then(res => res.text())
    .then(html => {
      document.getElementById('bodyDetailAbsensi').innerHTML = html;
      new bootstrap.Modal(document.getElementById('modalDetailAbsensi')).show();
    });
}
</script>
<script>
function openInputNilai(id) {

  document.getElementById('id_ekskul').value = id;

  fetch('<?= base_url("nilai/siswa") ?>/' + id)
    .then(r => r.text())
    .then(html => {
      document.getElementById('listNilai').innerHTML = html;
    });
}

</script>
<script>
function openLihatNilai(id) {
  fetch('<?= base_url("nilai/list") ?>/' + id)
    .then(r => r.text())
    .then(html => {
      document.getElementById('bodyLihatNilai').innerHTML = html;
    });
}
</script>
