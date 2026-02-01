<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Print Barcode</title>
<link 
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
  rel="stylesheet">
<style>
  body {
    background: white;
    font-family: Arial, sans-serif;
  }

  .toolbar {
    text-align: center;
    margin-bottom: 20px;
  }

  .barcode-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, 200px);
    gap: 20px;
    justify-content: center;
  }

  .barcode-item {
    border: 1px dashed #aaa;
    padding: 10px;
    text-align: center;
  }

  .barcode-item img {
    max-width: 180px;
  }

  .kode {
    font-size: 12px;
    margin-top: 5px;
  }

  .nama {
    font-weight: bold;
    font-size: 13px;
  }

  @media print {
    .toolbar {
      display: none;
    }

    body {
      margin: 0;
    }

    .barcode-item {
      page-break-inside: avoid;
      border: none;
    }
  }
</style>
</head>

<body>
<pre></pre>
<div class="toolbar">
  <button class="btn btn-primary btn-jumlah" data-jumlah="1">Print 1</button>
  <button class="btn btn-primary btn-jumlah" data-jumlah="3">Print 3</button>
  <button class="btn btn-primary btn-jumlah" data-jumlah="5">Print 5</button>
  <button class="btn btn-success btn-print">Print</button>
</div>


<div class="barcode-container" id="barcodeArea">
  <!-- barcode akan di-generate -->
</div>

<script>
const barang = {
  nama: "<?= esc($barang->nama_barang) ?>",
  kode: "<?= esc($barang->kode) ?>",
  barcodeUrl: "<?= base_url('barang/barcode/' . $barang->kode) ?>"
};

function setJumlah(jumlah) {
  const area = document.getElementById('barcodeArea');
  area.innerHTML = '';

  for (let i = 0; i < jumlah; i++) {
    area.innerHTML += `
      <div class="barcode-item">
        <img src="${barang.barcodeUrl}">
        <pre></pre>
        <div class="nama">${barang.nama}</div>
        <div class="kode">${barang.kode}</div>
      </div>
    `;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // tombol jumlah
  document.querySelectorAll('.btn-jumlah').forEach(btn => {
    btn.addEventListener('click', function () {
      const jumlah = this.dataset.jumlah;
      setJumlah(jumlah);
    });
  });

  // tombol print
  document.querySelector('.btn-print').addEventListener('click', function () {
    window.print();
  });

  // default tampil 1
  setJumlah(1);
});
</script>

</body>
</html>
