<!-- <?php $level = session()->get('level'); 
$status = $pengaduan->status;
?>


<h4>Respon Kesiswaan</h4>
<?php if (in_array($level, ['1','4'])): ?>

  <?php if ($status == 'Disetujui Wali Kelas'): ?>
      <form action="<?= base_url('pengaduan/tindak/'.$pengaduan->id_pengaduan) ?>" 
      method="post" 
      style="display:inline;">
    <button class="btn btn-warning mb-3"
            onclick="return confirm('Tindak pengaduan ini?')">
        🔧 Tindak
    </button>
</form>

  <?php elseif ($status == 'Ditindak Kesiswaan'): ?>
     <form action="<?= base_url('pengaduan/selesai/'.$pengaduan->id_pengaduan) ?>" 
      method="post" 
      style="display:inline;">
    <button class="btn btn-success mb-3"
            onclick="return confirm('Selesaikan pengaduan ini?')">
        ✅ Selesai
    </button>
</form>


  <?php endif; ?>

<?php endif; ?>
<div class="border p-3 mb-3" style="max-height:300px;overflow-y:auto;">

<?php if (empty($chat)): ?>
    <div class="text-center text-muted">
        <em>Belum ada respon dari kesiswaan.</em>
    </div>
<?php else: ?>
    <?php foreach ($chat as $c): ?>
        <div class="mb-3">
            <strong><?= esc($c->nama) ?></strong><br>
            <?= nl2br(esc($c->pesan)) ?>
            <div class="text-muted small"><?= $c->created_at ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>
<h5>Bukti dari Kesiswaan</h5>

<?php if (!empty($bukti)): ?>
  <div class="row">
    <?php foreach ($bukti as $b): ?>
      <div class="col-md-4 mb-3">
        <div class="border p-2 text-center">

            <a href="<?= base_url('assets/img/bukti/'.$b->file) ?>" target="_blank">
     <img 
            src="<?= base_url('assets/img/bukti/'.$b->file) ?>" 
            class="img-fluid rounded"
            style="max-height:200px;object-fit:contain;"
            alt="Bukti Kesiswaan">


          <div class="small text-muted mt-1">
            <?= $b->created_at ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <small class="text-muted">Belum ada bukti.</small>
<?php endif; ?>

</div>
<?php if (in_array($level, ['1','4'])): ?>
<form action="<?= base_url('pengaduan/kirimChat') ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_pengaduan" value="<?= $pengaduan->id_pengaduan ?>">

  <div class="mb-3">
    <textarea name="pesan" class="form-control" 
      placeholder="Tulis respon kesiswaan..."></textarea>
  </div>

  <div class="mb-3">
    <input type="file" name="file" class="form-control">
    <small class="text-muted">Opsional (jpg/png)</small>
  </div>

  <button class="btn btn-primary">Kirim Respon</button>
</form>
<?php endif; ?>
 -->
<h4>Respon Kesiswaan & Siswa</h4>

<div class="border p-3 mb-3" style="max-height:300px;overflow-y:auto;">

<?php if (empty($chat)): ?>
    <div class="text-center text-muted">
        <em>Belum ada chat.</em>
    </div>
<?php else: ?>
    <?php foreach ($chat as $c): ?>
        <div class="mb-3">
            <strong><?= esc($c->nama) ?> <?= ($c->level==2) ? '(Siswa)' : '' ?></strong><br>
            <?= nl2br(esc($c->pesan)) ?>
            <div class="text-muted small"><?= $c->created_at ?></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>

<h5>Bukti dari Kesiswaan</h5>
<?php if (!empty($bukti)): ?>
  <div class="row">
    <?php foreach ($bukti as $b): ?>
      <div class="col-md-4 mb-3">
        <div class="border p-2 text-center">
            <a href="<?= base_url('assets/img/bukti/'.$b->file) ?>" target="_blank">
                <img 
                    src="<?= base_url('assets/img/bukti/'.$b->file) ?>" 
                    class="img-fluid rounded"
                    style="max-height:200px;object-fit:contain;"
                    alt="Bukti Kesiswaan">
            </a>
          <div class="small text-muted mt-1"><?= $b->created_at ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <small class="text-muted">Belum ada bukti.</small>
<?php endif; ?>

<?php 
// Level yang bisa kirim chat: 1, 4 (kesiswaan/admin) + 2 (siswa)
if (in_array($level, ['1','2','4'])): 
?>
<form action="<?= base_url('pengaduan/kirimChat') ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id_pengaduan" value="<?= $pengaduan->id_pengaduan ?>">
  <input type="hidden" name="level" value="<?= $level ?>">

  <div class="mb-3">
    <textarea name="pesan" class="form-control" placeholder="<?= ($level==2) ? 'Tulis pesan untuk kesiswaan...' : 'Tulis respon kesiswaan...' ?>"></textarea>
  </div>

  <div class="mb-3">
    <input type="file" name="file" class="form-control">
    <small class="text-muted">Opsional (jpg/png)</small>
  </div>

  <button class="btn btn-primary">Kirim Chat</button>
</form>
<?php endif; ?>
