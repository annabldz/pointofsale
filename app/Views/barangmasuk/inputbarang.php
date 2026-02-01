<div class="card">
  <div class="card-body">
    <h5 class="card-title">Input Barang</h5>
    <form class="row g-3" action="<?= base_url('/barangmasuk/inputsave')?>" method="POST" enctype="multipart/form-data">
      
       <div class="col-12">
        <label class="form-label">Barang</label><br>
        <?php foreach ($barang as $lvl): ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="barang" id="barang<?= $lvl->id_barang ?>" value="<?= $lvl->id_barang ?>" required>
            <label class="form-check-label" for="barang<?= $lvl->id_barang ?>"><?= $lvl->nama_barang ?></label>
          </div>
        <?php endforeach; ?>
      </div>


      <div class="col-12">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
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
