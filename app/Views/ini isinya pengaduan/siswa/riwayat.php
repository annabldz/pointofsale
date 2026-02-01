

<div class="container mt-4">
     <div class="pagetitle">
      <h1>Riwayat Nilai</h1>
</div>
    <div class="row">
        <?php if (!empty($riwayat)) : ?>
            <?php foreach ($riwayat as $r) : ?>
                <div class="col-md-4 mb-0">
                    <div class="card shadow-sm border-0 h-85">
                        <div class="card-body">
                            <h5 class="card-title"><?= $r->nama_paket ?></h5>
                            <p class="card-text mb-1"><strong>Nilai:</strong> <?= esc($r->nilai) ?></p>
                            <p class="card-text mb-1"><strong>Mulai:</strong> <?= date('d M Y H:i', strtotime($r->waktu_mulai)) ?></p>
                            <p class="card-text mb-1"><strong>Selesai:</strong> <?= date('d M Y H:i', strtotime($r->waktu_selesai)) ?></p>
                            <p class="card-text"><strong>Status:</strong>  <?= esc($r->status) ?></p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <small class="text-muted">Nama Mapel: <?= esc($r->nama_mapel) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="alert alert-info">Belum ada riwayat ujian.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
