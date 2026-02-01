

    <div class="pagetitle">
      <h1>Tabel Kesiswaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Data Kesiswaan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <pre></pre>
              <a href="<?= base_url('/kesiswaan/input') ?>" class="btn btn-success mb-3 text-white">Tambah Data Kesiswaan</a>


              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $ms = 1; foreach ($love as $key => $value) { ?>
                    <tr>
                      <td><?= $ms++ ?></td>
                      <td><img src="<?= base_url('assets/img/' . $value->foto); ?>" width="45px" class="rounded-circle"></td>
                      <td><?= $value->nama ?></td>
                      <td><?= $value->username ?></td>
                      <td><?= $value->nik ?></td>
                      <td>
                        <button class="btn btn-info btn-detail" data-id="<?= $value->id_kesiswaan ?>"><i class="bi bi-info-circle" style="color: white;"></i></button>
                        <div class="btn-group btn-group-action mt-2" id="action-<?= $value->id_kesiswaan ?>" style="display: none;"> 
                          <a href="<?= base_url('/kesiswaan/hapus/' . $value->id_kesiswaan) ?>" class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></a><pre></pre>
                          <a href="<?= base_url('/kesiswaan/edit/' . $value->id_kesiswaan) ?>" class="btn btn-warning"><i class="bi bi-pencil" style="color: white;"></i></a> 
                        </div>
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
