<?php
$level = session()->get('level');
?>

    <div class="pagetitle">
      <h1>Tabel Penjualan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Data Penjualan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <pre></pre>
            

              <a href="<?= base_url('penjualan/input') ?>" class="btn btn-success mb-3 text-white">Tambah Data Penjualan</a>
              <?php if ($level === '1'): ?>

              <a href="<?= base_url('penjualan/deleted') ?>" class="btn btn-warning mb-3 text-black">Deleted Penjualan</a>
<?php endif; ?>
              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Pembeli</th>
                    <th scope="col">Tanggal Pembelian</th>
                    <th scope="col">Detail Pembelian</th>
                    <th scope="col">Nota</th>

                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $ms = 1; foreach ($love as $key => $value) { ?>
                    <tr>
                      <td><?= $ms++ ?></td>
                      
                      <td><?= $value->nama ?></td>
                      <td><?= $value->tanggal ?></td>
<td>
  <button 
    class="btn btn-sm btn-info btn-detail"
    data-id="<?= $value->id_penjualan ?>">
    <i class="bi bi-info-circle text-white"></i>
  </button>
</td>

<td>
  <a 
    href="<?= base_url('penjualan/nota/'.$value->id_penjualan) ?>" 
    class="btn btn-sm btn-success">
    <i class="bi bi-receipt"></i>
  </a>
</td>

<td>
  <a href="<?= base_url('penjualan/edit/'.$value->id_penjualan) ?>"
   class="btn btn-sm btn-warning text-white">
   <i class="bi bi-pencil"></i>
</a>

<?php if ($level === '1'): ?>

  <a href="<?= base_url('penjualan/soft/'.$value->id_penjualan) ?>" 
     class="btn btn-sm btn-danger"
     onclick="return confirm('Yakin hapus?')">
     <i class="bi bi-trash"></i>
  </a>
  <?php endif; ?>
</td>

                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Penjualan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent">
        <div class="text-center">Loading...</div>
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

  document.querySelectorAll('.btn-detail').forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.dataset.id;

      fetch(`<?= base_url('penjualan/detail') ?>/${id}`)
        .then(res => res.json())
        .then(res => {
          const items = res.items;
          const nota  = res.nota;

          let html = `
            <table class="table table-bordered mb-3">
              <thead>
                <tr>
                  <th>Barang</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
          `;

          items.forEach(i => {
            const subtotal = i.jumlah * i.harga;
            html += `
              <tr>
                <td>${i.nama_barang}</td>
                <td>${i.jumlah}</td>
                <td>${Number(i.harga).toLocaleString()}</td>
                <td>${subtotal.toLocaleString()}</td>
              </tr>
            `;
          });

          html += `
              </tbody>
            </table>

            <div class="row">
              <div class="col-md-6">
                <p><strong>Total</strong> : ${Number(nota.total).toLocaleString()}</p>
                <p><strong>Bayar</strong> : ${Number(nota.bayar).toLocaleString()}</p>
                <p><strong>Kembalian</strong> : ${Number(nota.kembalian).toLocaleString()}</p>
              </div>
              <div class="col-md-6 text-end">
                <span class="badge bg-${nota.status === 'Lunas' ? 'success' : 'warning'}">
                  ${nota.status}
                </span>
              </div>
            </div>
          `;

          document.getElementById('detailContent').innerHTML = html;
          new bootstrap.Modal(document.getElementById('modalDetail')).show();
        });
    });
  });

});
</script>
