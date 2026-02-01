<table class="table">
  <tr>
    <th>Nama</th>
    <th>Nilai</th>
  </tr>

  <?php foreach($siswa as $s){ ?>
  <tr>
    <td><?= $s->nama ?></td>
    <td>
     <input type="text" name="nilai[<?= $s->id_pendaftaran ?>]" value="<?= $s->nilai == '-' ? '' : $s->nilai ?>">

    </td>
  </tr>
  <?php } ?>
</table>
