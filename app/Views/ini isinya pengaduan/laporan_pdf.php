<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #eee; }
    </style>
</head>
<body>

<?php
$bulanIndo = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];
?>

<h3 style="text-align:center;">
Laporan Pengaduan Bulan <?= $bulanIndo[$bulan] ?> <?= $tahun ?><br>
<small>Rombel: <?= esc($nama_rombel) ?> </small>
</h3>

<p>
    <strong>Total Pengaduan:</strong> <?= count($pengaduan) ?><br>
    <strong>Total Siswa Mengadu:</strong> <?= $totalSiswa ?>
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pengaduan as $i => $p): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= esc($p->nama ?? '-') ?></td>
            <td><?= esc($p->judul) ?></td>
            <td><?= esc($p->status) ?></td>
            <td><?= $p->tanggal ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

</body>
</html>
