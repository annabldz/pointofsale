<?php if(count($ekskul) > 0): ?>
    <ul>
        <?php foreach($ekskul as $e): ?>
            <li><?= $e->nama_ekskul ?> (<?= $e->hari ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Siswa belum mengambil ekskul.</p>
<?php endif; ?>
