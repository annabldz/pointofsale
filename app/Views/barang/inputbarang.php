<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Barang</h5>
    <form class="row g-3" action="<?= base_url('/barang/inputsave')?>" method="POST" enctype="multipart/form-data">
      
      <div class="col-12">
        <label for="file" class="form-label">Foto</label>
        <input type="file" class="form-control" id="file" name="file" accept="img/" required>
      </div>

      <div class="col-12">
        <label for="nama" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="col-12">
  <label for="kode" class="form-label">Kode</label>
  <input type="text" class="form-control" id="kode" name="kode">
  <small class="text-muted">
    Kosongkan jika ingin generate otomatis
  </small>
</div>


      <div class="col-12">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="">-- Pilih Status --</option>
          <option value="Tersedia">Tersedia</option>
          <option value="Stok Habis">Stok Habis</option>
        </select>
      </div>

      <div class="col-12">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" class="form-control" id="stok" name="stok" required>
      </div>

      <div class="col-12">
        <label for="harga" class="form-label">Harga</label>
        <input type="text" class="form-control rupiah" id="harga" name="harga" required>
      </div>

      <div class="col-12">
        <label for="modal" class="form-label">Modal</label>
        <input type="text" class="form-control rupiah" id="modal" name="modal" required>
      </div>

      <div class="col-12">
        <label class="form-label">Kategori</label><br>
        <?php foreach ($kategori as $lvl): ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="kategori" id="kategori<?= $lvl->id_kategori ?>" value="<?= $lvl->id_kategori ?>" required>
            <label class="form-check-label" for="kategori<?= $lvl->id_kategori ?>"><?= $lvl->nama_kategori ?></label>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>

    </form>
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
