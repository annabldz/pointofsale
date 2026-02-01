<?php
namespace App\Controllers;
use App\Models\M_Barang;
use App\Models\M_Penjualan;
use App\Models\M_ekskul;
use App\Models\M_log;

class Penjualan extends BaseController
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
        $hehe['love'] = $this->M_ekskul->penjualan();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Penjualan.');

        echo view('/admin/header', $hee);
        echo view('/penjualan/penjualan', $hehe);
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
        $hehe['love'] = $this->M_ekskul->penjualandelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Penjualan.');

        echo view('/admin/header', $hee);
        echo view('/penjualan/deleted', $hehe);
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
        
        // $where = ['penjualan.id_penjualan' => $id];
        // $hehe['love'] = $this->M_ekskul->
        // jwhere2('nota', 'user', 'penjualan.id_nota=nota.id_nota', 'penjualan.id_user=user.id_user', $where);

            $db = \Config\Database::connect();

    $penjualan = $db->table('penjualan p')
        ->select('p.*, n.bayar, n.kembalian, n.status')
        ->join('nota n', 'n.id_nota = p.id_nota')
        ->where('p.id_penjualan', $id)
        ->get()->getRow();

    $detail = $db->table('penjualan_detail pd')
        ->select('pd.id_detail, pd.id_barang, b.nama_barang, pd.jumlah, b.harga')
        ->join('barang b', 'b.id_barang = pd.id_barang')
        ->where('pd.id_penjualan', $id)
        ->where('pd.isdelete', 0)
        ->get()->getResult();


        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Penjualan.');
        echo view('/admin/header', $hee);
        echo view('penjualan/editpenjualan', [
        'penjualan' => $penjualan,
        'detail'    => $detail]);
        echo view('/admin/footer');
    }
public function approveHapus()
{
    $password = $this->request->getPost('password');
    $password_md5 = md5($password); // hash input

    $db = \Config\Database::connect();

    $user = $db->table('user')
        ->whereIn('level', ['1','2','3'])
        ->where('password', $password_md5)
        ->get()
        ->getRowArray();

    if ($user) {
        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Password salah atau bukan user berwenang'
    ]);
}

    public function editsave()
    {
        // $request = service('request');
        // $session = session();

        // $id = $request->getPost('id');
        // $id_login = $session->get('id');
        // $password = $request->getPost('password');

        // // $foto = $request->getFile('file');
        // // $namaFileFoto = null;

        // // if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        // //     $namaFileFoto = $foto->getRandomName();
        // //     $foto->move('assets/img/', $namaFileFoto);

        // //     $userLama = $this->M_ekskul->getWhere('barang', ['id_barang' => $id]);
        // //     if ($userLama && $userLama->foto && file_exists('assets/img/' . $userLama->foto)) {
        // //         unlink('assets/img/' . $userLama->foto);
        // //     }
        // // }

        // $dataAlumni = [
        //     'id_user' => $request->getPost('user'),
        //     '' => $request->getPost('nama'),
        //     'kode' => $request->getPost('kode'),
        //     'status' => $request->getPost('status'),
        //     'harga' => $request->getPost('harga'),
        //     'modal' => $request->getPost('modal'),
        //     'stok' => $request->getPost('stok'),
        //     'updated_at' => date('Y-m-d H:i:s'),
        //     'updated_by' => $id_login
        // ];

        // // if ($namaFileFoto) {
        // //     $dataAlumni['foto'] = $namaFileFoto;
        // // }

        // $whereAlumni = ['id_barang' => $id];
        // $this->M_ekskul->edit('barang', $dataAlumni, $whereAlumni);
        
        $db->transStart();

// ambil detail lama
$oldDetails = $db->table('penjualan_detail')
    ->where('id_penjualan', $id_penjualan)
    ->get()->getResult();

// kembalikan stok
foreach ($oldDetails as $old) {
    $db->table('barang')
       ->set('stok', 'stok + '.$old->jumlah, false)
       ->where('id_barang', $old->id_barang)
       ->update();
}

// update detail + hitung total
$total = 0;
foreach ($items as $id_detail => $item) {
    $subtotal = $item['jumlah'] * $item['harga'];
    $total += $subtotal;

    $db->table('penjualan_detail')
        ->update(['jumlah' => $item['jumlah']], ['id_detail' => $id_detail]);

  
}

// update nota
$kembalian = $bayar - $total;

$db->table('nota')->update([
    'total' => $total,
    'bayar' => $bayar,
    'kembalian' => $kembalian,
    'status' => $kembalian >= 0 ? 'Lunas' : 'Belum Lunas'
], ['id_nota' => $penjualan->id_nota]);

$db->transComplete();

        log_activity(session()->get('id'), "Mengedit penjualan: {$dataAlumni['id_penjualan']}");

        return redirect()->to('penjualan');
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
        $result = $this->M_ekskul->softpenjualan($id_alumni);
        log_activity(session()->get('id'), "Menghapus data penjualan dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'penjualan berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'penjualan tidak ditemukan');
        }

        return redirect()->to('penjualan/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorepenjualan($id_alumni);
        log_activity(session()->get('id'), "Merestore data penjualan dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'penjualan berhasil direstore');
        } else {
            session()->setFlashdata('error', 'penjualan tidak ditemukan');
        }

        return redirect()->to('penjualan');
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
  



    // Ajax ambil data barang berdasarkan kode
    public function getBarang()
    {
        $kode = $this->request->getPost('kode');
        $barang = (new M_Barang())->where('kode', $kode)->first();

        if($barang) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $barang
            ]);
        } else {
            return $this->response->setJSON(['status'=>'error', 'message'=>'Barang tidak ditemukan']);
        }
    }

    // Simpan penjualan
    public function save()
{
    $session = session();
    $id_login = $session->get('id');

    $barang = $this->request->getPost('barang'); // array: id_barang, jumlah, harga
    $bayar = (int) $this->request->getPost('bayar');
$kembalian = (int) $this->request->getPost('kembalian');

if (is_string($barang)) {
    $barang = json_decode($barang, true); // true supaya jadi array
}

// pastikan $barang array
if (!is_array($barang)) {
    return redirect()->back()->with('error', 'Data barang tidak valid');
}
    $db = \Config\Database::connect();
    $db->transStart(); // start transaction

    // 1. Insert ke penjualan
    $id_penjualan = $db->table('penjualan')->insert([
        'id_user' => $id_login,
        'tanggal' => date('Y-m-d H:i:s'),
        'created_by' => $id_login,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $id_penjualan = $db->insertID();

    $total = 0;
    foreach($barang as $b){
        $subtotal = $b['jumlah'] * $b['harga'];
        $total += $subtotal;

        // insert detail
        $db->table('penjualan_detail')->insert([
            'id_penjualan' => $id_penjualan,
            'id_barang' => $b['id_barang'],
            'jumlah' => $b['jumlah'],
            'isdelete' => 0,
            'created_by' => $id_login,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // update stok
//         $stok = (new M_Barang())->find($b['id_barang']);
// $newStok = $stok->stok - $b['jumlah'];
//         (new M_Barang())->update($b['id_barang'], ['stok' => $newStok]);
    }

    // 2. Insert ke nota
    $id_nota = $db->table('nota')->insert([
    'total' => $total,
    'bayar' => $bayar,
    'kembalian' => $kembalian,
    'status' => ($kembalian >= 0 ? 'Lunas' : 'Belum Lunas'),
    'created_by' => $id_login,
    'created_at' => date('Y-m-d H:i:s')
]);


    $id_nota = $db->insertID();

    // update penjualan dengan id_nota
    $db->table('penjualan')->update(['id_nota' => $id_nota], ['id_penjualan' => $id_penjualan]);

    $db->transComplete();

    return redirect()->to('/penjualan/nota/'.$id_penjualan);
}
public function detail($id)
{
    $db = \Config\Database::connect();

    // 1. Detail barang
    $items = $db->table('penjualan_detail pd')
        ->select('b.nama_barang, pd.jumlah, b.harga')
        ->join('barang b', 'b.id_barang = pd.id_barang')
        ->where('pd.id_penjualan', $id)
        ->where('pd.isdelete', 0)
        ->get()->getResult();

    // 2. Data nota (lewat penjualan)
    $nota = $db->table('penjualan p')
        ->select('n.total, n.bayar, n.kembalian, n.status')
        ->join('nota n', 'n.id_nota = p.id_nota')
        ->where('p.id_penjualan', $id)
        ->where('n.isdelete', 0)
        ->get()->getRow();

    return $this->response->setJSON([
        'items' => $items,
        'nota'  => $nota
    ]);
}



    public function nota($id_penjualan)
{
    $db = \Config\Database::connect();

    // ambil data penjualan
    $penjualan = $db->table('penjualan')->where('id_penjualan', $id_penjualan)->get()->getRowArray();

    // ambil detail
    $detail = $db->table('penjualan_detail')
                 ->join('barang', 'barang.id_barang = penjualan_detail.id_barang')
                 ->where('id_penjualan', $id_penjualan)
                 ->get()->getResultArray();

    return view('/nota', [
        'penjualan' => $penjualan,
        'detail' => $detail
    ]);
}

public function bayar()
{
    $id_nota = $this->request->getPost('id_nota');
    $bayar = $this->request->getPost('bayar');

    $db = \Config\Database::connect();
    $nota = $db->table('nota')->where('id_nota', $id_nota)->get()->getRowArray();

    if(!$nota){
        return $this->response->setJSON(['status'=>'error','message'=>'Nota tidak ditemukan']);
    }

    $kembalian = $bayar - $nota['total'];
    $status = ($kembalian >= 0) ? 'Lunas' : 'Belum Lunas';

    $db->table('nota')->update([
        'bayar' => $bayar,
        'kembalian' => $kembalian,
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ], ['id_nota' => $id_nota]);

    return $this->response->setJSON([
        'status' => 'success',
        'kembalian' => $kembalian,
        'status_nota' => $status
    ]);
}



}
