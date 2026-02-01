

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
              <?php if (in_array(session()->get('level'), ['2'])): ?>

              <a href="<?= base_url('/pengaduan/input') ?>" class="btn btn-success mb-3 text-white">Input Pengaduan</a>
              <?php endif; ?>
 
<?php if (in_array(session()->get('level'), ['1','4'])): ?>

<?php
$bulanIndo = [
    1  => 'Januari',
    2  => 'Februari',
    3  => 'Maret',
    4  => 'April',
    5  => 'Mei',
    6  => 'Juni',
    7  => 'Juli',
    8  => 'Agustus',
    9  => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
?>

<form action="<?= base_url('pengaduan/laporanBulanan') ?>" method="get" target="_blank" class="mb-3 d-flex gap-2 align-items-center">

    <!-- Dropdown Bulan -->
    <select name="bulan" required class="form-select w-auto">
        <?php foreach ($bulanIndo as $num => $nama): ?>
            <option value="<?= $num ?>" <?= (isset($bulan) && $bulan == $num) ? 'selected' : '' ?>><?= $nama ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Dropdown Tahun -->
    <select name="tahun" required class="form-select w-auto">
        <?php for ($y = date('Y'); $y >= 2022; $y--): ?>
            <option value="<?= $y ?>" <?= (isset($tahun) && $tahun == $y) ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
    </select>

    <!-- Dropdown Rombel -->
    <select name="id_rombel" class="form-select w-auto">
        <option value="">-- Semua Rombel --</option>
        <?php foreach ($rombel as $r): ?>
            <option value="<?= $r->id_rombel ?>" <?= (isset($id_rombel) && $id_rombel == $r->id_rombel) ? 'selected' : '' ?>>
                <?= $r->nama_kelas ?> <?= $r->nama_jurusan ?> - <?= $r->nama_rombel ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-danger">
        Cetak Laporan Bulanan
    </button>
</form>


<?php endif; ?>


              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Status</th>   
                    <th scope="col">Disetujui Oleh</th>
                    <th scope="col">Detail Penyelesaian</th>
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
                    
                      <td><?= $value->nama_siswa  ?></td>
                      <td><?= $value->judul ?></td>
                      <td><?= $value->status ?></td>
                      <td><?= $value->nama_guru ?? '-' ?></td>

                      <td>
  <a href="<?= base_url('pengaduan/detail/'.$value->id_pengaduan) ?>"
     class="btn btn-sm btn-info">
     Detail
  </a>
</td>

                    <?php
          if (session()->get('level')==1 || session()->get('level')==3 ){ ?>
                      <td>
<button 
  class="btn btn-info btn-lihat"
  data-id="<?= $value->id_pengaduan ?>"
  data-judul="<?= $value->judul ?>"
  data-deskripsi="<?= $value->deskripsi ?>"
  data-tanggal="<?= date('d-m-Y', strtotime($value->tanggal)) ?>"
  data-status="<?= $value->status ?>"
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
  const btnSetujui = document.getElementById('btnSetujui');
  const btnTolak   = document.getElementById('btnTolak');

  document.querySelectorAll('.btn-lihat').forEach(button => {
    button.addEventListener('click', function () {
      const status = this.dataset.status;

      document.getElementById('pengaduan_id').value = this.dataset.id;
      document.getElementById('detailJudul').innerText = this.dataset.judul;
      document.getElementById('detailDeskripsi').innerText = this.dataset.deskripsi;
      document.getElementById('detailTanggal').innerText = this.dataset.tanggal;

      // 🔐 LOGIKA STATUS
      if (
        status === 'Menunggu Persetujuan Wali Kelas' &&
        (<?= session()->get('level') ?> == 1 || <?= session()->get('level') ?> == 3)
      ) {
        btnSetujui.style.display = 'inline-block';
        btnTolak.style.display   = 'inline-block';
      } else {
        btnSetujui.style.display = 'none';
        btnTolak.style.display   = 'none';
      }

      modal.show();
    });
  });

  btnSetujui.addEventListener('click', function () {
    const id = document.getElementById('pengaduan_id').value;
    window.location.href = `<?= base_url('/pengaduan/setujui/') ?>` + id;
  });

  btnTolak.addEventListener('click', function () {
    const id = document.getElementById('pengaduan_id').value;
    window.location.href = `<?= base_url('/pengaduan/tolak/') ?>` + id;
  });
});
</script>
