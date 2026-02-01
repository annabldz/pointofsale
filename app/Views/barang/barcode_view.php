<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Barcode <?= esc($kode) ?></title>
  <style>
    body {
      margin: 0;
      background: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    img {
      max-width: 90%;
    }
  </style>
</head>
<body>
  <img src="<?= base_url('barang/barcode/' . $kode) ?>" alt="Barcode">
</body>
</html>
