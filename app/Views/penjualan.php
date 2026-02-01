<div class="card">
  <div class="card-body">
    <h5 class="card-title">Penjualan</h5>
    <form id="formPenjualan" method="POST" action="<?= base_url('/penjualan/save') ?>">
      <div class="mb-3">
        <label>Kode Barang</label>
        <input type="text" id="kode" class="form-control" autofocus>
      </div>

      <table class="table" id="tableBarang">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <input type="hidden" name="barang" id="barangData">
      <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
    </form>
  </div>
</div>

<script>
let barangList = [];

document.getElementById('kode').addEventListener('keypress', function(e){
  if(e.key === 'Enter'){
    e.preventDefault();
    const kode = this.value;
    fetch("<?= base_url('/penjualan/getBarang') ?>", {
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:'kode='+kode
    }).then(res => res.json())
      .then(data => {
        if(data.status === 'success'){
          addBarang(data.data);
          this.value = '';
        }else{
          alert(data.message);
        }
      });
  }
});

function addBarang(barang){
  const existing = barangList.find(b => b.id_barang == barang.id_barang);
  if(existing){
    existing.jumlah++;
    existing.subtotal = existing.harga * existing.jumlah;
  } else {
    barang.jumlah = 1;
    barang.subtotal = barang.harga;
    barangList.push(barang);
  }
  renderTable();
}

function renderTable(){
  const tbody = document.querySelector('#tableBarang tbody');
  tbody.innerHTML = '';
  barangList.forEach((b, i) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${b.nama_barang}</td>
      <td>${b.harga}</td>
      <td><input type="number" value="${b.jumlah}" onchange="updateJumlah(${i}, this.value)"></td>
      <td>${b.subtotal}</td>
      <td><button type="button" onclick="hapusBarang(${i})">Hapus</button></td>
    `;
    tbody.appendChild(tr);
  });
  document.getElementById('barangData').value = JSON.stringify(barangList);
}

function updateJumlah(index, jumlah){
  barangList[index].jumlah = parseInt(jumlah);
  barangList[index].subtotal = barangList[index].harga * barangList[index].jumlah;
  renderTable();
}

function hapusBarang(index){
  barangList.splice(index,1);
  renderTable();
}
</script>
