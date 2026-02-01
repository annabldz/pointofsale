<table class="table table-bordered">
  <thead>
    <tr>
      <th>Tanggal</th>
      <th>Barang</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Subtotal</th>
      <th>Modal</th>
      <th>Pendapatan Bersih</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($laporan as $r): ?>
    <tr>
      <td><?= $r->tanggal ?></td>
      <td><?= $r->nama_barang ?></td>
      <td><?= number_format($r->harga) ?></td>
      <td><?= $r->jumlah ?></td>
      <td><?= number_format($r->subtotal) ?></td>
      <td><?= number_format($r->modal) ?></td>
      <td class="fw-bold text-success">
        <?= number_format($r->pendapatan_bersih) ?>
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
