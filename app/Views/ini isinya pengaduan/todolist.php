<style>
.done {
  text-decoration: line-through;
  color: gray;
}

.item-actions{
  float:right;
}
</style>

<div class="pagetitle">
      <h1>TO DO LIST</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">TO DO LIST</li>
        </ol>
         <a href="<?=base_url ('/input')?>" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Task</a>
      </nav>
     
    </div><!-- End Page Title -->
 
    <section class="section dashboard">
      <section class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                
                <div class="card-body">
                  <h5 class="card-title">Total Task</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-list"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $totalTask ?></h6>


                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

               
                <div class="card-body">
                  <h5 class="card-title">Tugas Selesai</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-check"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $taskSelesai ?></h6>


                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                

                <div class="card-body">
                  <h5 class="card-title">Belum Selesai</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clock"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $taskBelumSelesai ?></h6>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->
    </div></div></section>
    <section class="section">
      
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">To Do List</h5>
              <p>List tugas yang harus dikerjakan</p>
               <ul class="list-group" id="todo-list">
              <?php foreach($yupigkdone as $t): ?>
               <li class="list-group-item">
                  <input type="checkbox" onchange="updateStatus(<?= $t->id;?>, 'Selesai', this)">
                  <?= $t->nama; ?> - <?= $t->prioritas; ?> - Deadline <?= $t->tanggal; ?>

                  <div class="item-actions dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="<?= base_url('edit/'.$t->id) ?>" class="dropdown-item">Edit</a></li>
                      <li><a class="dropdown-item text-danger" href="<?= base_url('delete/'.$t->id) ?>">Hapus</a></li>
                    </ul>
                  </div>
                </li>

              <?php endforeach;?>
              </ul>

            </div>
          </div>

        </div>

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Done Task</h5>
              <p>List tugas selesai</p>
              <ul class="list-group" id="done-list">
              <?php foreach($yupi as $t): ?>
              <li class="list-group-item done">
                <input type="checkbox" checked onchange="updateStatus(<?= $t->id;?>, 'Belum Selesai', this)">
                <?= $t->nama; ?> - <?= $t->prioritas; ?> - Deadline <?= $t->tanggal; ?>

                <div class="item-actions dropdown">
                  <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="<?= base_url('edit/'.$t->id) ?>" class="dropdown-item">Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('delete/'.$t->id) ?>">Hapus</a></li>
                  </ul>
                </div>
              </li>

              <?php endforeach;?>
              </ul>

            </div>
          </div>

        </div>
      </div>
    </section>
<script>
function updateStatus(id, status, el) {
    // Update status in the backend
    fetch("<?= base_url('/updatestatus'); ?>", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify({ id:id, status:status })
    })
    .then(r => r.json())
    .then(res => {
        const li = el.closest("li");

        // Update the task's class and move it to the correct list
        if (status === "Selesai") {
            li.classList.add("done");
            document.getElementById("done-list").appendChild(li);
            el.checked = true;
            el.setAttribute("onchange", `updateStatus(${id}, 'Belum Selesai', this)`);

            // Update the count for tasks
            updateTaskCounts('done');
        } else {
            li.classList.remove("done");
            document.getElementById("todo-list").appendChild(li);
            el.checked = false;
            el.setAttribute("onchange", `updateStatus(${id}, 'Selesai', this)`);

            // Update the count for tasks
            updateTaskCounts('todo');
        }
    });
}

// Function to update task counts dynamically
function updateTaskCounts(listType) {
    // Update the count of tasks dynamically
    let totalTasks = document.querySelectorAll("#todo-list li").length + document.querySelectorAll("#done-list li").length;
    let completedTasks = document.querySelectorAll("#done-list li").length;
    let pendingTasks = document.querySelectorAll("#todo-list li").length;

    // Update the card counts
    document.querySelector(".card-title:contains('Total Task') + .ps-3 h6").textContent = totalTasks;
    document.querySelector(".card-title:contains('Tugas Selesai') + .ps-3 h6").textContent = completedTasks;
    document.querySelector(".card-title:contains('Belum Selesai') + .ps-3 h6").textContent = pendingTasks;
}
</script>
