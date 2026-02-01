<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarangMasuk extends BaseController
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
        $hehe['love'] = $this->M_ekskul->barangmasuk();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Barang Masuk.');

        echo view('/admin/header', $hee);
        echo view('/barangmasuk/barang', $hehe);
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
        $hehe['love'] = $this->M_ekskul->barangmasukdelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Barang Masuk.');

        echo view('/admin/header', $hee);
        echo view('/barangmasuk/deleted', $hehe);
        echo view('/admin/footer');
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
        
        $where = ['barang_masuk.id_masuk' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('barang_masuk', 'barang', 'barang_masuk.id_barang=barang.id_barang', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Barang Masuk.');
        echo view('/admin/header', $hee);
        echo view('/barangmasuk/editbarang', $hehe);
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
            'id_barang' => $request->getPost('barang'),
            'jumlah' => $request->getPost('jumlah'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        if ($namaFileFoto) {
            $dataAlumni['foto'] = $namaFileFoto;
        }

        $whereAlumni = ['id_masuk' => $id];
        $this->M_ekskul->edit('barang_masuk', $dataAlumni, $whereAlumni);
        
        log_activity(session()->get('id'), "Mengedit barang masuk: {$dataAlumni['id_barang']}");

        return redirect()->to('barangmasuk');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('barang_masuk', ['id_masuk' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'barang masuk berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'barang masuk tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus barang masuk ID: $id_alumni");


        return redirect()->to('barang masuk');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softbarangmasuk($id_alumni);
        log_activity(session()->get('id'), "Menghapus data barang masuk dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'barang masuk berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'barang masuk tidak ditemukan');
        }

        return redirect()->to('barangmasuk/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorebarangmasuk($id_alumni);
        log_activity(session()->get('id'), "Merestore data barang masuk dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'barang masuk berhasil direstore');
        } else {
            session()->setFlashdata('error', 'barang masuk tidak ditemukan');
        }

        return redirect()->to('barangmasuk');
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
        
        $hehe['barang'] = $this->M_ekskul->barang();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Barang Masuk.');

        echo view('/admin/header', $hee);
        echo view('/barangmasuk/inputbarang', $hehe);
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
            'id_barang' => $this->request->getPost('barang'),
            'jumlah' => $this->request->getPost('jumlah'),
            
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('barang_masuk', $userData);
        log_activity(session()->get('id'), "Menambahkan barang masuk: {$userData['id_barang']}");

        return redirect()->to(base_url('barangmasuk'));
    }
  


public function generateBarcode()
{
    // 12 digit angka (EAN-13 tanpa checksum)
    $kode = '';
    for ($i = 0; $i < 12; $i++) {
        $kode .= rand(0,9);
    }

    // generate barcode image
    $generator = new BarcodeGeneratorPNG();
    $barcodeImage = $generator->getBarcode(
        $kode,
        $generator::TYPE_EAN_13,
        2,
        60
    );

    // simpan image
    $path = FCPATH . 'assets/img/barcode/';
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }

    $filename = 'barcode_' . $kode . '.png';
    file_put_contents($path . $filename, $barcodeImage);

    return $this->response->setJSON([
        'status' => 'success',
        'kode' => $kode,
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