<!DOCTYPE html>
<html>
<head>
    <title>Nilai Ekskul</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h3 { text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Daftar Nilai Ekskul</h3>
    <p>Nama Siswa: <strong><?= $nama ?></strong></p>

    <table>
        <tr>
            <th>No</th>
            <th>Ekskul</th>
            <th>Nilai</th>
        </tr>
        <?php $no = 1; foreach($nilai as $n): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $n->nama_ekskul ?></td>
            <td><?= $n->nilai ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
