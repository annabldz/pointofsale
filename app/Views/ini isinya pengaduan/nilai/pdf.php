<!DOCTYPE html>
<html>
<head>
    <title>Nilai Ekskul</title>
</head>
<body>
<h3>Daftar Nilai Ekskul</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Ekskul</th>
        <th>Nilai</th>
    </tr>
    <?php $no=1; foreach($nilai as $n): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $n->nama ?></td>
        <td><?= $n->nama_ekskul ?></td>
        <td><?= $n->nilai ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
