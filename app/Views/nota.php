<?php
$db = \Config\Database::connect();
$setting = $db->table('nota_setting')
              ->where('isdelete', 0)
              ->orderBy('id_notset', 'DESC')
              ->get()
              ->getRowArray();
?>

<!-- 
<h3 style="text-align:center">TOKO MEY</h3>
<p>Tanggal: <?= date('d-m-Y H:i', strtotime($penjualan['tanggal'])) ?></p>
<hr>

<table style="width:100%">
<tr>
<th>Barang</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>
</tr>
<?php 
$total = 0;
foreach($detail as $d): 
    $subtotal = $d['jumlah'] * $d['harga'];
    $total += $subtotal;
?>
<tr>
<td><?= $d['nama_barang'] ?></td>
<td><?= $d['jumlah'] ?></td>
<td><?= number_format($d['harga'],0,',','.') ?></td>
<td><?= number_format($subtotal,0,',','.') ?></td>
</tr>
<?php endforeach; ?>
</table>
<hr>

<p style="text-align:right"><b>Total: Rp <?= number_format($total,0,',','.') ?></b></p>

<?php if(isset($penjualan['id_nota'])): 
    $db = \Config\Database::connect();
    $nota = $db->table('nota')->where('id_nota', $penjualan['id_nota'])->get()->getRowArray();
?>
<p style="text-align:right">Bayar: Rp <?= number_format($nota['bayar'],0,',','.') ?></p>
<p style="text-align:right">Kembalian: Rp <?= number_format($nota['kembalian'],0,',','.') ?></p>
<p style="text-align:right">Status: <?= $nota['status'] ?></p>

<?php if($nota['status'] != 'Lunas'): ?>
<form id="formBayar">
  <input type="hidden" name="id_nota" value="<?= $penjualan['id_nota'] ?>">
  <label>Bayar:</label>
  <input type="number" name="bayar" required>
  <button type="submit">Bayar</button>
</form>
<?php else: ?>
<p style="text-align:center;color:green"><b>Nota sudah lunas ✅</b></p>
<?php endif; ?>

<?php endif; ?>

<script>
let formBayar = document.getElementById('formBayar');
if(formBayar){
  formBayar.addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("<?= base_url('/penjualan/bayar') ?>", {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'success'){
        alert('Pembayaran berhasil! Kembalian: Rp '+data.kembalian);
        location.reload(); // reload biar update status & kembalian muncul
      } else {
        alert('Gagal: '+data.message);
      }
    })
    .catch(err => console.error(err));
  });
}
</script>

<p style="text-align:center">Terima kasih telah berbelanja!</p>
<button onclick="window.print()">Cetak Nota</button> -->

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Struk Penjualan</title>

<style>
body {
    font-family: 'Courier New', Courier, monospace;
    font-size: 10px;
    margin: 0;
    padding: 5px;
    width: 58mm;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.bold { font-weight: bold; }

.dashed-line {
    border-top: 1px dashed #000;
    margin: 5px 0;
}

.header {
    text-align: center;
    margin-bottom: 5px;
}

.store-name {
    font-size: 14px;
    font-weight: bold;
}

.meta-info {
    display: flex;
    justify-content: space-between;
    font-size: 9px;
}

.item-name {
    display: block;
}

.item-detail {
    display: flex;
    justify-content: space-between;
}

.footer {
    margin-top: 10px;
    font-size: 9px;
    text-align: center;
}

@media print {
    @page { margin: 0; }
}
</style>
</head>

<body onload="window.print()">
<div class="header">
  <?php if(!empty($setting['logo'])): ?>
    <img src="<?= base_url('assets/img/'.$setting['logo']) ?>" style="max-width:50px;margin-bottom:5px">
  <?php endif; ?>

  <div class="store-name"><?= $setting['title'] ?? 'TOKO' ?></div>
  <div><?= $setting['alamat'] ?? '-' ?></div>
  <div><?= $setting['notelp'] ?? '' ?></div>
</div>
<div class="dashed-line"></div>

<div class="meta-info">
  <span><?= date('d.m.y-H:i', strtotime($penjualan['tanggal'])) ?></span>
  <span><?= substr($penjualan['id_penjualan'], -8) ?></span>
  <span>KASIR</span>
</div>

<div class="dashed-line"></div>
<?php 
$total = 0;
foreach($detail as $d): 
  $subtotal = $d['jumlah'] * $d['harga'];
  $total += $subtotal;
?>

<div>
  <div class="item-name"><?= $d['nama_barang'] ?></div>
  <div class="item-detail">
    <span><?= $d['jumlah'] ?> x <?= number_format($d['harga'],0,',','.') ?></span>
    <span><?= number_format($subtotal,0,',','.') ?></span>
  </div>
</div>

<?php endforeach; ?>
<div class="dashed-line"></div>

<div class="item-detail bold">
  <span>TOTAL</span>
  <span><?= number_format($total,0,',','.') ?></span>
</div>

<?php if(isset($nota)): ?>
<div class="item-detail">
  <span>BAYAR</span>
  <span><?= number_format($nota['bayar'],0,',','.') ?></span>
</div>

<div class="item-detail">
  <span>KEMBALI</span>
  <span><?= number_format($nota['kembalian'],0,',','.') ?></span>
</div>
<?php endif; ?>
<div class="dashed-line"></div>

<div class="footer">
  <div>TERIMA KASIH</div>
  <div>SELAMAT BERBELANJA KEMBALI</div>
  <div>LAYANAN KONSUMEN</div>
</div>

</body>
</html>
