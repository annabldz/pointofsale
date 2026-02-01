<div id="content">

<div class="pagetitle">
  <h1>Edit Barang Masuk</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Tables</li>
      <li class="breadcrumb-item active">Edit Barang Masuk</li>
    </ol>
  </nav>
</div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Barang Masuk</h5>
          <form class="row g-3" id="editAlumniForm" action="<?=base_url('/barangmasuk/editsave')?>" method="POST" enctype="multipart/form-data" >

            <div class="col-12">
              <label for="barang" class="form-label">Barang</label>
              <?php foreach ($barang as $lvl): ?>
                <div class="form-check ">
                  <input class="form-check-input" type="radio" name="barang" id="barang<?= $lvl->id_barang ?>"
                    value="<?= $lvl->id_barang ?>" <?= ($love->id_barang == $lvl->id_barang) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="barang<?= $lvl->id_barang ?>"><?= $lvl->nama_barang ?></label>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="col-12">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $love->jumlah ?>">
            </div>

            <input type="hidden" name="id" value="<?= $love->id_masuk ?>">


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
