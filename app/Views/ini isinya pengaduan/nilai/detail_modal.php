<table class="table table-bordered">
  <tr>
    <th>Nama Siswa</th>
    <th>Keterangan</th>
  </tr>

  <?php foreach ($detail as $d) { ?>
  <tr>
    <td><?= $d->nama ?></td>
    <td>
      <span class="badge bg-primary"><?= $d->keterangan ?></span>
    </td>
  </tr>
  <?php } ?>

</table>
