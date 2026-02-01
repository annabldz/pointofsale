  <style>
  #tableBarang input[type="number"]{
    width: 60px;
    padding: 2px 4px;
  }

  #tableBarang button{
    font-size: 12px;
  }
  </style>

      <div class="pagetitle">

        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">

    <a href="<?= base_url('download/sql') ?>" class="btn btn-success">
      Download SQL Terbaru
  </a>

  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body">

        <h5 class="card-title d-flex justify-content-between align-items-center">
          <span>🧾 Kasir Penjualan</span>
          <span class="badge bg-success">POS</span>
        </h5>

        <form id="formPenjualan" method="POST" action="<?= base_url('/penjualan/save') ?>">

          <div class="mb-3">
            <label class="form-label fw-bold">Kode Barang</label>
            <input type="text" id="kode" class="form-control form-control-lg" autofocus>
          </div>

          <table class="table table-sm align-middle" id="tableBarang">
            <thead class="table-light">
              <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <!-- Modal Approve Hapus -->
<div class="modal fade" id="modalApprove" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">🔒 Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="password" id="approvePassword" class="form-control"
               placeholder="Masukkan password leader kasir">
        <input type="hidden" id="indexHapus">
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
<button type="button" class="btn btn-danger" onclick="approveHapus()">
  Approve
</button>
      </div>
    </div>
  </div>
</div>

  <hr>

  <div class="row mb-2">
    <div class="col-6 fw-bold">Total</div>
    <div class="col-6 text-end fw-bold" id="totalText">0</div>
  </div>

  <div class="row mb-2">
    <div class="col-6 fw-bold">Bayar</div>
    <div class="col-6">
      <!-- <input type="number" id="bayarInput" class="form-control form-control-sm text-end" placeholder="0"> -->
       <input type="text" id="bayarInput"
  class="form-control form-control-sm text-end"
  placeholder="Rp 0">

    </div>
  </div>

  <div class="row mb-3">
    <div class="col-6 fw-bold">Kembalian</div>
    <div class="col-6 text-end fw-bold text-success" id="kembalianText">0</div>
  </div>

          <input type="hidden" name="barang" id="barangData">
          <input type="hidden" name="bayar" id="bayarHidden">
  <input type="hidden" name="kembalian" id="kembalianHidden">


          <button type="submit" class="btn btn-primary w-100">
            Simpan Penjualan
          </button>

        </form>

      </div>
    </div>
  </div>


  </div>
  <script>
  let barangList = [];

  document.getElementById('kode').addEventListener('keypress', function(e){
    if(e.key === 'Enter'){
      e.preventDefault();
      const kode = this.value;
      fetch("<?= base_url('/penjualan/getBarang') ?>", {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'kode='+kode
      }).then(res => res.json())
        .then(data => {
          if(data.status === 'success'){
            addBarang(data.data);
            this.value = '';
          }else{
            alert(data.message);
          }
        });
    }
  });

  function addBarang(barang){
    const existing = barangList.find(b => b.id_barang == barang.id_barang);
    if(existing){
      existing.jumlah++;
      existing.subtotal = existing.harga * existing.jumlah;
    } else {
      barang.jumlah = 1;
      barang.subtotal = barang.harga;
      barangList.push(barang);
    }
    renderTable();
  }
  function renderTable(){
    const tbody = document.querySelector('#tableBarang tbody');
    tbody.innerHTML = '';

    barangList.forEach((b, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${b.nama_barang}</td>
        <td>${b.harga}</td>
        <td><input type="number" value="${b.jumlah}" onchange="updateJumlah(${i}, this.value)"></td>
        <td>${b.subtotal}</td>
        <td>
  <button type="button" onclick="showModalHapus(${i})">Hapus</button>
</td>

      `;
      tbody.appendChild(tr);
    });

    const total = hitungTotal();
    document.getElementById('totalText').innerText = formatRupiah(total);

    document.getElementById('barangData').value = JSON.stringify(barangList);
  }

  function updateJumlah(index, jumlah){
    barangList[index].jumlah = parseInt(jumlah);
    barangList[index].subtotal = barangList[index].harga * barangList[index].jumlah;
    renderTable();
  }
function showModalHapus(index){
  document.getElementById('indexHapus').value = index;
  document.getElementById('approvePassword').value = '';
  new bootstrap.Modal(document.getElementById('modalApprove')).show();
}
function approveHapus(){
  event.preventDefault(); // 🔒 cegah submit form

  const password = document.getElementById('approvePassword').value;
  const index = document.getElementById('indexHapus').value;

  fetch("<?= base_url('/penjualan/approveHapus') ?>", {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'password=' + encodeURIComponent(password)
  })
  .then(res => res.json())
  .then(res => {
    if(res.status === 'success'){
      barangList.splice(index, 1);
      renderTable();
      bootstrap.Modal.getInstance(
        document.getElementById('modalApprove')
      ).hide();
    } else {
      alert(res.message);
    }
  });
}

  function hapusBarang(index){
    barangList.splice(index,1);
    renderTable();
  }
  </script>
  <script>
  function hitungTotal(){
    let total = 0;
    barangList.forEach(b => total += b.subtotal);
    return total;
  }

  function formatRupiah(angka){
    return 'Rp ' + angka.toLocaleString('id-ID');
  }

  document.getElementById('bayarInput')?.addEventListener('input', function () {
  // ambil angka murni
  const raw = this.value.replace(/[^0-9]/g, '');
  const bayar = parseInt(raw || 0);

  // tampilkan format Rp
  this.value = formatRupiahInput(raw);

  const total = hitungTotal();
  const kembali = bayar - total;

  document.getElementById('kembalianText').innerText =
    kembali >= 0 ? formatRupiah(kembali) : 'Rp 0';

  // nilai asli buat backend
  document.getElementById('bayarHidden').value = bayar;
  document.getElementById('kembalianHidden').value =
    kembali >= 0 ? kembali : 0;
});
  </script>
<script>
function formatRupiahInput(value) {
  value = value.replace(/[^,\d]/g, '').toString();
  const split = value.split(',');
  let sisa = split[0].length % 3;
  let rupiah = split[0].substr(0, sisa);
  const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    const separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  return rupiah ? 'Rp ' + rupiah : '';
}
</script>
