<div id="content">

<div class="pagetitle">
  <h1>Edit Barang</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Barang</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Barang</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/barang/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="file" class="form-label">Foto</label>
              <input type="file" class="form-control" id="file" name="file" accept="img/" value="<?= $love->foto ?>" ><pre></pre>
              <img src="<?= base_url('assets/img/' . $love->foto) ?>" style="height: 100px; width: 100px;">
            </div>
            <div class="col-12">
              <label for="nama" class="form-label">Nama Barang:</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?= $love->nama_barang ?>">
            </div>

            <div class="col-12">
              <label for="kode" class="form-label">Kode</label>
              <input type="text" class="form-control" id="kode" name="kode" value="<?= $love->kode ?>">
            </div>

            <div class="col-12">
  <label for="status" class="form-label">Status</label>
  <select class="form-select" id="status" name="status">
    <option value="Tersedia" <?= ($love->status == 'Tersedia') ? 'selected' : '' ?>>Tersedia</option>
    <option value="Stok Habis" <?= ($love->status == 'Stok Habis') ? 'selected' : '' ?>>Stok Habis</option>
  </select>
</div>

<div class="col-12">
              <label for="stok" class="form-label">Stok</label>
              <input type="text" class="form-control" id="stok" name="stok" value="<?= $love->stok ?>">
            </div>

            
<div class="col-12">
  <label for="harga" class="form-label">Harga</label>
  <input type="text" class="form-control rupiah" id="harga" name="harga" value="<?= number_format($love->harga ?? 1000, 0, ',', ',') ?>">
</div>

<div class="col-12">
  <label for="modal" class="form-label">Modal</label>
  <input type="text" class="form-control rupiah" id="modal" name="modal" value="<?= number_format($love->modal ?? 1000, 0, ',', ',') ?>">
</div>

            
            <div class="col-12">
              <label for="kategori" class="form-label">Kategori</label>
              <?php foreach ($kategori as $lvl): ?>
                <div class="form-check ">
                  <input class="form-check-input" type="radio" name="kategori" id="kategori<?= $lvl->id_kategori ?>"
                    value="<?= $lvl->id_kategori ?>" <?= ($love->id_kategori == $lvl->id_kategori) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="kategori<?= $lvl->id_kategori ?>"><?= $lvl->nama_kategori ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <input type="hidden" name="id" value="<?= $love->id_barang ?>">


            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function formatRupiah(input) {
    let value = input.value.replace(/\D/g, ''); // ambil angka saja
    if(value === '') value = '0'; 
    input.dataset.value = value; // simpan angka murni
    input.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
  }

  document.querySelectorAll('.rupiah').forEach(el => {
    el.addEventListener('input', function() {
      formatRupiah(this);
    });

    // inisialisasi saat load
    formatRupiah(el);
  });

  // saat form disubmit, ganti value dengan angka murni
  const form = document.querySelector('form');
  form.addEventListener('submit', function() {
    document.querySelectorAll('.rupiah').forEach(el => {
      el.value = el.dataset.value; // value murni dikirim ke server
    });
  });
</script>
