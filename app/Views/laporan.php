<div class="row mb-3">
  <div class="col-md-3">
    <input type="month" id="bulan" class="form-control">
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary" onclick="loadChart()">Filter</button>
  </div>
  <div class="col-md-3">
    <a id="btnExport" class="btn btn-success" target="_blank">
      Export Excel
    </a>
  </div>
</div>


<div id="chartPendapatan" style="height:400px;"></div>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
const chart = echarts.init(document.getElementById('chartPendapatan'));

function loadChart() {
  const bulan = document.getElementById('bulan').value;

  fetch(`<?= base_url('laporan/chartPendapatan') ?>?bulan=${bulan}`)
    .then(res => res.json())
    .then(data => {

      const tanggal = data.map(d => d.tanggal);
      const kotor = data.map(d => d.pendapatan_kotor);
      const bersih = data.map(d => d.pendapatan_bersih);

      chart.setOption({
        title: { text: 'Pendapatan Kotor & Bersih' },
        tooltip: { trigger: 'axis' },
        legend: { data: ['Pendapatan Kotor', 'Pendapatan Bersih'] },
        xAxis: { type: 'category', data: tanggal },
        yAxis: { type: 'value' },
        series: [
          { name: 'Pendapatan Kotor', type: 'bar', data: kotor },
          { name: 'Pendapatan Bersih', type: 'line', data: bersih }
        ]
      });

      // set link export sesuai filter
      document.getElementById('btnExport').href =
        `<?= base_url('laporan/exportExcel') ?>?bulan=${bulan}`;
    });
}

// load pertama kali (bulan ini)
loadChart();
</script>
