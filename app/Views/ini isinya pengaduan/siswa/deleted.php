

    <div class="pagetitle">
      <h1>Tabel Deleted Siswa</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Deleted Data Siswa</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <pre></pre>
                <a href="<?= base_url('olimpiade/siswa') ?>" class="btn btn-info mb-3 text-white">Back to Siswa</a>
              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Asal Sekolah</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $ms = 1; foreach ($love as $key => $value) { ?>
                    <tr>
                      <td><?= $ms++ ?></td>
                      <td><img src="<?= base_url('assets_olimpiade/img/' . $value->foto); ?>" width="45px" class="rounded-circle"></td>
                      <td><?= $value->nama ?></td>
                      <td><?= $value->username ?></td>
                      <td><?= $value->nis ?></td>
                      <td><?= $value->nama_kelas ?></td>
                      <td><?= $value->nama_sekolah ?></td>
                      <td>
                        <a href="<?= base_url('olimpiade/siswa/restore/' . $value->id_siswa) ?>" class="btn btn-danger btn-delete"><i class="bi bi-arrow-counterclockwise"></i></a><pre></pre> <!-- restore -->
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const detailButtons = document.querySelectorAll('.btn-detail');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const inputButton = document.querySelector('.btn-inputalumni');

    detailButtons.forEach(button => {
      button.addEventListener('click', function () {
        const alumniId = this.dataset.id;
        const actionDiv = document.getElementById('action-' + alumniId);
        actionDiv.style.display = (actionDiv.style.display === 'none' || actionDiv.style.display === '') ? 'block' : 'none';
      });
    });
  });

</script>
