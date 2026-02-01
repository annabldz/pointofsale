<div class="pagetitle">
    <?php if(!empty($siswa)) : ?>
        <h1>Daftar Siswa Kelas 
            <?= $siswa[0]->nama_kelas ?> 
            <?= $siswa[0]->nama_jurusan ?> 
            <?= $siswa[0]->nama_rombel ?>
        </h1>
    <?php else : ?>
        <h1>Anda tidak memegang kelas.</h1>
    <?php endif; ?>
</div>

<?php if(!empty($siswa)) : ?>
<table class="table datatable">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($siswa as $s) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $s->nis ?></td>
            <td><?= $s->nama ?></td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="lihatEkskul(<?= $s->id_siswa ?>)">
                    Lihat Ekskul
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<div class="modal fade" id="modalEkskul" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ekskul Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="modalBodyEkskul">
        <!-- isi ekskul akan di-load via AJAX -->
      </div>
    </div>
  </div>
</div>
<script>
    function lihatEkskul(id_siswa) {
    fetch('<?= base_url("nilai/ekskulSiswa") ?>/' + id_siswa)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalBodyEkskul').innerHTML = html;
            var modal = new bootstrap.Modal(document.getElementById('modalEkskul'));
            modal.show();
        })
        .catch(err => console.error(err));
}
</script>