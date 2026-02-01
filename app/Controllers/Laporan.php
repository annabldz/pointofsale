<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Laporan extends BaseController
{

 	protected $session;
    protected $M_ekskul;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_ekskul = new M_ekskul(); 
        $this->db = \Config\Database::connect();
		helper(['url', 'log']);
    }

    public function index () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $logModel = new M_log(); 
        $db = \Config\Database::connect();

        // ambil semua menu
        $menu_all = $db->table('menu')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('id_menu', 'ASC')
            ->get()
            ->getResultArray();

        // ambil privileges user
        $privs = $db->table('privileges')
            ->where('id_level', $level)
            ->get()
            ->getResultArray();

        $privileges = [];
        foreach ($privs as $p){
            $privileges[$p['id_menu']] = true;
        }

        // passing ke view
        $hee['menu_all'] = $menu_all;
        $hee['privileges'] = $privileges;
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Laporan.');

        echo view('/admin/header', $hee);
        echo view('/laporan');
        echo view('/admin/footer');
    }

 public function chartPendapatan()
{
    $bulan = $this->request->getGet('bulan'); // format: YYYY-MM
    $whereBulan = '';

    if ($bulan) {
        $whereBulan = "AND DATE_FORMAT(p.tanggal, '%Y-%m') = '$bulan'";
    }

    $data = $this->db->query("
        SELECT 
            DATE(p.tanggal) AS tanggal,
            SUM(pd.jumlah * b.harga) AS pendapatan_kotor,
            SUM((pd.jumlah * b.harga) - (pd.jumlah * b.modal)) AS pendapatan_bersih
        FROM penjualan p
        JOIN penjualan_detail pd ON pd.id_penjualan = p.id_penjualan
        JOIN barang b ON b.id_barang = pd.id_barang
        WHERE p.isdelete = 0
          AND pd.isdelete = 0
          $whereBulan
        GROUP BY DATE(p.tanggal)
        ORDER BY tanggal ASC
    ")->getResult();

    return $this->response->setJSON($data);
}
public function exportExcel()
{
    $bulan = $this->request->getGet('bulan');
    $whereBulan = '';

    if ($bulan) {
        $whereBulan = "AND DATE_FORMAT(p.tanggal, '%Y-%m') = '$bulan'";
    }

    $data = $this->db->query("
        SELECT 
            DATE(p.tanggal) AS tanggal,
            u.nama AS diinput_oleh,
            b.nama_barang,
            b.harga,
            pd.jumlah,
            (pd.jumlah * b.harga) AS subtotal,
            (pd.jumlah * b.modal) AS modal,
            ((pd.jumlah * b.harga) - (pd.jumlah * b.modal)) AS pendapatan_bersih
        FROM penjualan p
        JOIN penjualan_detail pd ON pd.id_penjualan = p.id_penjualan
        JOIN barang b ON b.id_barang = pd.id_barang
        LEFT JOIN user u ON u.id_user = p.created_by
        WHERE p.isdelete = 0
          AND pd.isdelete = 0
          $whereBulan
        ORDER BY p.tanggal ASC
    ")->getResultArray();

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_penjualan_detail.xls");

    echo "Tanggal\tDiinput Oleh\tBarang\tHarga\tJumlah\tSubtotal\tModal\tPendapatan Bersih\n";

    $totalKotor  = 0;
    $totalBersih = 0;

    foreach ($data as $d) {
        $totalKotor  += $d['subtotal'];
        $totalBersih += $d['pendapatan_bersih'];

        echo "{$d['tanggal']}\t{$d['diinput_oleh']}\t{$d['nama_barang']}\t{$d['harga']}\t{$d['jumlah']}\t{$d['subtotal']}\t{$d['modal']}\t{$d['pendapatan_bersih']}\n";
    }

    // INFO RINGKAS DI BAWAH
    echo "\n";
    echo "Total Pendapatan Kotor\t{$totalKotor}\n";
    echo "Total Pendapatan Bersih\t{$totalBersih}\n";

    exit;
}



}