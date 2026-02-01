<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_Barang;
use App\Models\M_log;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Barang extends BaseController
{
 	protected $session;
    protected $M_ekskul;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_ekskul = new M_ekskul(); 
        $this->M_barang = new M_Barang(); 
        $this->db = \Config\Database::connect();
		helper(['url', 'log']);
    }

    public function index () {
      

        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

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
        $hehe['love'] = $this->M_ekskul->barang();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Barang.');

        echo view('/admin/header', $hee);
        echo view('/barang/barang', $hehe);
        echo view('/admin/footer');
    }

    public function deleted () {

		 $level = $this->session->get('level');
        $id_user = $this->session->get('id');

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
        $hehe['love'] = $this->M_ekskul->barangdelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Barang.');

        echo view('/admin/header', $hee);
        echo view('/barang/deleted', $hehe);
        echo view('/admin/footer');
    }
public function viewBarcode($kode)
{
    return view('barang/barcode_view', [
        'kode' => $kode
    ]);
}
public function printBarcode($id)
{
    $barang = $this->M_barang->getById($id); // sesuaikan model kamu

    return view('barang/print_barcode', [
        'barang' => $barang
    ]);
}

    public function edit ($id) {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

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

        $hehe['kategori'] = $this->M_ekskul->kategori();
        
        $where = ['barang.id_barang' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('barang', 'kategori', 'barang.id_kategori=kategori.id_kategori', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Barang.');
        echo view('/admin/header', $hee);
        echo view('/barang/editbarang', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $session = session();

        $id = $request->getPost('id');
        $id_login = $session->get('id');
        $password = $request->getPost('password');

        $foto = $request->getFile('file');
        $namaFileFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFileFoto = $foto->getRandomName();
            $foto->move('assets/img/', $namaFileFoto);

            $userLama = $this->M_ekskul->getWhere('barang', ['id_barang' => $id]);
            if ($userLama && $userLama->foto && file_exists('assets/img/' . $userLama->foto)) {
                unlink('assets/img/' . $userLama->foto);
            }
        }

        $dataAlumni = [
            'id_kategori' => $request->getPost('kategori'),
            'nama_barang' => $request->getPost('nama'),
            'kode' => $request->getPost('kode'),
            'status' => $request->getPost('status'),
            'harga' => $request->getPost('harga'),
            'modal' => $request->getPost('modal'),
            'stok' => $request->getPost('stok'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        if ($namaFileFoto) {
            $dataAlumni['foto'] = $namaFileFoto;
        }

        $whereAlumni = ['id_barang' => $id];
        $this->M_ekskul->edit('barang', $dataAlumni, $whereAlumni);
        
        log_activity(session()->get('id'), "Mengedit barang: {$dataAlumni['nama_barang']}");

        return redirect()->to('barang');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('barang', ['id_barang' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'barang berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'barang tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus barang ID: $id_alumni");


        return redirect()->to('barang');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softbarang($id_alumni);
        log_activity(session()->get('id'), "Menghapus data barang dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'barang berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'barang tidak ditemukan');
        }

        return redirect()->to('barang/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorebarang($id_alumni);
        log_activity(session()->get('id'), "Merestore data barang dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'barang berhasil direstore');
        } else {
            session()->setFlashdata('error', 'barang tidak ditemukan');
        }

        return redirect()->to('barang');
    }

    public function input () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

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
        
        $hehe['kategori'] = $this->M_ekskul->kategori();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Barang.');

        echo view('/admin/header', $hee);
        echo view('/barang/inputbarang', $hehe);
        echo view('/admin/footer');
    }
      private function generateKodeBarang()
{
    // contoh: 12 digit angka (aman buat barcode)
    do {
        $kode = '';
        for ($i = 0; $i < 12; $i++) {
            $kode .= rand(0, 9);
        }

        // cek ke database biar gak dobel
        $exists = $this->db->table('barang')
            ->where('kode', $kode)
            ->countAllResults();

    } while ($exists > 0);

    return $kode;
}

    public function inputsave()
    {
        $session = session();
        $id_login = $session->get('id');

        $file = $this->request->getFile('file');
        $filename = '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filename = $file->getRandomName();
            $file->move('assets/img', $filename);
        }

        $password = md5('1');

        $kodeInput = trim($this->request->getPost('kode'));

if ($kodeInput === '') {
    $kodeInput = $this->generateKodeBarang();
}

        $userData = [
            'foto' => $filename,
            'nama_barang' => $this->request->getPost('nama'),
            'id_kategori' => $this->request->getPost('kategori'),
            'kode' => $kodeInput,
            'status' => $this->request->getPost('status'),
            'harga' => $this->request->getPost('harga'),
            'modal' => $this->request->getPost('modal'),
            'stok' => $this->request->getPost('stok'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('barang', $userData);
        log_activity(session()->get('id'), "Menambahkan barang: {$userData['nama_barang']}");

        return redirect()->to(base_url('barang'));
    }
  
private function hitungChecksumEAN13($kode12)
{
    $total = 0;

    for ($i = 0; $i < 12; $i++) {
        $digit = (int) $kode12[$i];
        $total += ($i % 2 === 0) ? $digit : $digit * 3;
    }

    return (10 - ($total % 10)) % 10;
}

public function generateBarcode()
{
    // 12 digit awal
    $kode12 = '';
    for ($i = 0; $i < 12; $i++) {
        $kode12 .= rand(0, 9);
    }

    // hitung checksum
    $checksum = $this->hitungChecksumEAN13($kode12);

    // 13 digit final
    $kode13 = $kode12 . $checksum;

    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
    $barcodeImage = $generator->getBarcode(
        $kode13,
        $generator::TYPE_EAN_13,
        2,
        60
    );

    // simpan image
    $path = FCPATH . 'assets/img/barcode/';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $filename = 'barcode_' . $kode13 . '.png';
    file_put_contents($path . $filename, $barcodeImage);

    return $this->response->setJSON([
        'status' => 'success',
        'kode' => $kode13,
        'image' => base_url('assets/img/barcode/' . $filename)
    ]);
}

public function barcodeFromKode($kode)
{
    if (!ctype_digit($kode)) {
        exit;
    }

    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode(
        $kode,
        $generator::TYPE_EAN_13,
        2,
        60
    );

    return $this->response
        ->setHeader('Content-Type', 'image/png')
        ->setBody($barcode);
}

}