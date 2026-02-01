<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Pengaturan Hak Akses Menu</h5>

          <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
 <thead class="table-light">
    <tr>
        <th style="width:200px">Level</th>
        <?php foreach ($menu as $m): ?>
            <?php if ($m['url'] != '#'): ?>
                <th><?= $m['nama_menu']; ?></th>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
</thead>

<tbody>
    <?php foreach ($level as $l): ?>
    <tr>
        <td class="text-start fw-bold"><?= $l['nama_level']; ?></td>

        <?php foreach ($menu as $m): ?>
            <?php if ($m['url'] != '#'): ?>
            <td>
                <input
                    type="checkbox"
                    class="form-check-input privilege-checkbox"
                    data-level="<?= $l['id_level']; ?>"
                    data-menu="<?= $m['id_menu']; ?>"
                    <?= isset($privileges[$l['id_level']][$m['id_menu']]) ? 'checked' : ''; ?>
                >
            </td>
            <?php endif; ?>
        <?php endforeach; ?>

    </tr>
    <?php endforeach; ?>
</tbody>



            </table>

            <div id="loadingPrivileges" class="text-center my-2" style="display:none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div>Sedang menyimpan...</div>
</div>

            <div class="mt-3 text-end">
    <button id="savePrivileges" class="btn btn-primary">Simpan Hak Akses</button>
</div>

          </div>

          <div class="mt-3">
            <small class="text-muted">
              Centang menu untuk mengaktifkan akses pada level terkait.
            </small>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>
<script>
document.getElementById('savePrivileges').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.privilege-checkbox');
    let data = [];

    checkboxes.forEach(cb => {
        data.push({
            level: cb.dataset.level,
            menu: cb.dataset.menu,
            checked: cb.checked ? 1 : 0
        });
    });

    const loading = document.getElementById('loadingPrivileges');
    const btnSave = this;

    // tampilkan loading & disable tombol
    loading.style.display = 'block';
    btnSave.disabled = true;

    fetch('<?= base_url("menu/save") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            '<?= csrf_header(); ?>': '<?= csrf_hash(); ?>'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            alert('Hak akses berhasil disimpan!');
        } else {
            alert('Gagal menyimpan hak akses.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan!');
    })
    .finally(() => {
        // hide loading & enable tombol kembali
        loading.style.display = 'none';
        btnSave.disabled = false;
    });
});

</script>
