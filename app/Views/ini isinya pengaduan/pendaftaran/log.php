

    <div class="pagetitle">
      <h1>Tabel Log</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Table Data</li>
          <li class="breadcrumb-item active">Data Log</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <pre></pre>
    

              <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama User</th>
                    <th scope="col">Activity</th>
                    <th scope="col">IP Address</th>
                    <th scope="col">Created At</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $ms = 1; foreach ($love as $key => $value) { ?>
                    <tr>
                      <td><?= $ms++ ?></td>
                      <td><?= $value->username ?></td>
                      <td><?= $value->activity ?></td>
                      <td><?= $value->ip_address ?></td>
                      <td><?= $value->created_at ?></td>
                      
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

    editButtons.forEach(button => {
      button.addEventListener('click', function () {
        const alumniId = this.dataset.id;
        const url = window.location.origin + '/alumni/alumni/editalumni/' + alumniId;


        fetch(url)
          .then(response => response.text())
          .then(data => {
            document.getElementById('content').innerHTML = data;
            history.pushState(null, '', '/alumni/alumni');
            initializeCropper();
            initializeInputAlumniScript();
          })
          .catch(error => console.error('Error:', error));
      });
    });

    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const alumniId = this.dataset.id;
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
          // window.location.href = '<?= base_url("alumni/alumni/hapusalumni/") ?>' + alumniId;
          window.location.href = '<?= rtrim(base_url("alumni/alumni/hapusalumni"), "/") . "/" ?>' + alumniId;

        }
      });
    });

    if (inputButton) {
      inputButton.addEventListener('click', function (e) {
        e.preventDefault(); 
        if (confirm('Apakah Anda yakin ingin menambah data alumni?')) {
          fetch('<?= base_url("alumni/alumni/inputalumni") ?>')
            .then(res => res.text())
            .then(html => {
              document.getElementById('content').innerHTML = html;
              history.pushState(null, '', '/alumni/alumni');
              initializeCropper();
              initializeInputAlumniScript();
            })
            .catch(err => console.error('Gagal load halaman input:', err));
        }
      });
    }
  });

    function initializeCropper() {
  let cropper;
  const input = document.getElementById('file');
  const image = document.getElementById('imagePreview');
  const previewImage = document.getElementById('croppedPreview');

  if (input && image && previewImage) {
    input.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (event) {
        image.src = event.target.result;
        image.style.display = 'block';

        if (cropper) cropper.destroy();

        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 2,
          autoCropArea: 0.8,
          guides: true,
          center: true,
          highlight: true,
          background: true,
          movable: false,
          zoomable: true,
          cropBoxMovable: true,
          cropBoxResizable: true,
          minContainerHeight: 400,
          crop(event) {
            const canvas = cropper.getCroppedCanvas({ width: 100, height: 100 });
            previewImage.src = canvas.toDataURL();
          }
        });
      };
      reader.readAsDataURL(file);
    });

    document.querySelector('form').addEventListener('submit', function (e) {
      if (cropper) {
        e.preventDefault();
        cropper.getCroppedCanvas().toBlob((blob) => {
          const fileInput = document.getElementById('file');
          const newFile = new File([blob], "cropped.png", { type: "image/png" });
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(newFile);
          fileInput.files = dataTransfer.files;
          this.submit();
        });
      }
    });
  }
}

function initializeInputAlumniScript() {
    const pendidikanRadios = document.querySelectorAll('input[name="status_pendidikan"]');
    const tempatSMADiv = document.getElementById('tempatSMADiv');
    const tempatSMKDiv = document.getElementById('tempatSMKDiv');
    const tempatKuliahDiv = document.getElementById('tempatKuliahDiv');

    pendidikanRadios.forEach(radio => {
      radio.addEventListener('change', function () {
        tempatSMADiv.style.display = "none";
        tempatSMKDiv.style.display = "none";
        tempatKuliahDiv.style.display = "none";

        if (this.value === "SMA") {
          tempatSMADiv.style.display = "block";
        } else if (this.value === "SMK") {
          tempatSMKDiv.style.display = "block";
        } else if (this.value === "Kuliah") {
          tempatKuliahDiv.style.display = "block";
        }
      });
    });
  


    const bekerjaRadios = document.querySelectorAll('input[name="bekerja"]');
    const tempatBekerjaDiv = document.getElementById('tempatBekerjaDiv');

    bekerjaRadios.forEach(radio => {
      radio.addEventListener('change', function () {
        if (this.value === "Iya") {
          tempatBekerjaDiv.style.display = "block";
        } else {
          tempatBekerjaDiv.style.display = "none";
       }
    });
  });
}
</script>
