
<form action="<?= base_url('penjualan/editsave') ?>" method="post">

<input type="hidden" name="id_penjualan" value="<?= $penjualan->id_penjualan ?>">

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Barang</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($detail as $i): ?>
    <tr>
      <td><?= $i->nama_barang ?></td>
      <td><?= number_format($i->harga) ?></td>
      <td>
        <input type="number"
               name="items[<?= $i->id_detail ?>][jumlah]"
               value="<?= $i->jumlah ?>"
               min="1"
               class="form-control jumlah">
        <input type="hidden"
               name="items[<?= $i->id_detail ?>][harga]"
               value="<?= $i->harga ?>">
        <input type="hidden"
               name="items[<?= $i->id_detail ?>][id_barang]"
               value="<?= $i->id_barang ?>">
      </td>
      <td class="subtotal"><?= number_format($i->jumlah * $i->harga) ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>

<div class="mb-3">
  <label>Bayar</label>
  <input type="number" name="bayar" value="<?= $penjualan->bayar ?>" class="form-control">
</div>

<button class="btn btn-primary">Simpan Perubahan</button>
</form>
