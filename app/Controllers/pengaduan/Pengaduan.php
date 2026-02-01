<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;
use Dompdf\Dompdf;

class Pengaduan extends BaseController
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
$id_rombel = $this->request->getGet('id_rombel');
    $bulan     = $this->request->getGet('bulan');
    $tahun     = $this->request->getGet('tahun');

    $hehe['rombel'] = $db->table('rombel')->join('kelas', 'rombel.id_kelas=kelas.id_kelas')->join('jurusan', 'rombel.id_jurusan=jurusan.id_jurusan')->get()->getResult();
    $hehe['id_rombel'] = $id_rombel;
    $hehe['bulan'] = $bulan;
    $hehe['tahun'] = $tahun;

    // ambil data pengaduan sesuai filter
    $hehe['love'] = $this->M_ekskul->getPengaduanFilter($level, $id_user, $id_rombel, $bulan, $tahun);

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
        // ================= PENGADUAN (ROLE BASED) =================
        // if ($level == '1') {
        //     // ADMIN → lihat semua
        //     $hehe['love'] = $this->M_ekskul->pengaduan();

        // } elseif ($level == '3') {
        //     // GURU (wali kelas) → hanya siswa rombel dia
        //     $hehe['love'] = $this->M_ekskul->pengaduanguru($id_user);

        // } elseif ($level == '2') {
        //     // SISWA → hanya pengaduan sendiri
        //     $hehe['love'] = $this->M_ekskul->pengaduansiswa($id_user);

        // } elseif ($level == '4') {
        //     // LEVEL 4 → hanya yang sudah disetujui wali kelas
        //     $hehe['love'] = $this->M_ekskul->pengaduanDisetujui();

        // } else {
        //     $hehe['love'] = [];
        // }


                
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Pengaduan.');

        echo view('/admin/header', $hee);
        echo view('/pengaduan/index', $hehe);
        echo view('/admin/footer');
    }

    // public function setujui($id)
    // {
    //     $level = session()->get('level');

    //     // proteksi role
    //     if (!in_array($level, ['1','3'])) {
    //         return redirect()->back();
    //     }

    //     $this->M_ekskul->updateStatusPengaduan(
    //         $id,
    //         'Disetujui Wali Kelas'
    //     );

    //     return redirect()->to('/pengaduan')
    //         ->with('success', 'Pengaduan berhasil disetujui');
    // }
    public function setujui($id)
{
    $level = session()->get('level');
    $id_guru = session()->get('id'); // 🔥 ID guru login

    // proteksi role
    if (!in_array($level, ['1','3'])) {
        return redirect()->back();
    }

    $this->M_ekskul->updateStatusPengaduan(
        $id,
        'Disetujui Wali Kelas',
        $id_guru
    );

    return redirect()->to('/pengaduan')
        ->with('success', 'Pengaduan berhasil disetujui');
}


    public function tolak($id)
    {
        $level = session()->get('level');

        // proteksi role
        if (!in_array($level, ['1','3'])) {
            return redirect()->back();
        }

        $this->M_ekskul->updateStatusPengaduan(
            $id,
            'Pengaduan Ditolak'
        );

        return redirect()->to('/pengaduan')
            ->with('success', 'Pengaduan berhasil ditolak');
    }


     public function guru () {
      

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
        $hehe['love'] = $this->M_ekskul->pengaduanguru($id_user);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Pengaduan.');

        echo view('/admin/header', $hee);
        echo view('/pengaduan/indexguru', $hehe);
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

        $hehe['level'] = $this->M_ekskul->level();
        
        $where = ['pengaduan.id_pengaduan' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere2('pengaduan', 'siswa', 'user', 'pengaduan.id_siswa=siswa.id_siswa', 'siswa.id_user=user.id_user', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Pengaduan.');
        echo view('/admin/header', $hee);
        echo view('/pengaduan/edit', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $password = $request->getPost('password');

        $foto = $request->getFile('file');
        $namaFileFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFileFoto = $foto->getRandomName();
            $foto->move('assets/img/', $namaFileFoto);

            $userLama = $this->M_ekskul->getWhere('user', ['id_user' => $id]);
            if ($userLama && $userLama->foto && file_exists('assets/img/' . $userLama->foto)) {
                unlink('assets/img/' . $userLama->foto);
            }
        }

        $dataAlumni = [
            'id_siswa' => $request->getPost('id_siswa'),
            'judul' => $request->getPost('judul'),
            'deskripsi' => $request->getPost('deskripsi'),
            'status' => $request->getPost('status'),
            'tanggal' => $request->getPost('tanggal'),
        ];

        // if ($namaFileFoto) {
        //     $dataAlumni['foto'] = $namaFileFoto;
        // }

        $whereAlumni = ['id_pengaduan' => $id];
        $this->M_ekskul->edit('pengaduan', $dataAlumni, $whereAlumni);
        
        log_activity(session()->get('id'), "Mengedit pengaduan: {$dataAlumni['judul']}");

        return redirect()->to('pengaduan');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('pengaduan', ['id_pengaduan' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'pengaduan berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'pengaduan tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus pengaduan ID: $id_alumni");


        return redirect()->to('pengaduan');
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
        
        $hehe['level'] = $this->M_ekskul->level();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Pengaduan.');

        echo view('/admin/header', $hee);
        echo view('/pengaduan/input', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

        $db = \Config\Database::connect();
        $idUser = session()->get('id');
        $idSiswa = $db->table('siswa')
            ->select('id_siswa')
            ->where('id_user', $idUser)
            ->get()
            ->getRow('id_siswa');

        if (!$idSiswa) {
    return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
}


        $file = $this->request->getFile('file');
        $filename = '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filename = $file->getRandomName();
            $file->move('assets/img', $filename);
        }
            // 'foto' => $filename,

        $userData = [
            'id_siswa'   => $idSiswa,
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => "Menunggu Persetujuan Wali Kelas",
            'tanggal' => $this->request->getPost('tanggal'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $success = $this->M_ekskul->input('pengaduan', $userData);
        log_activity(session()->get('id'), "Menambahkan pengaduan: {$userData['judul']}");

        return redirect()->to(base_url('pengaduan'));
    }

 public function detail($id_pengaduan) {
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
        
        $data['pengaduan'] = $this->M_ekskul->getPengaduanById($id_pengaduan);
    $data['chat']      = $this->M_ekskul->getChatByPengaduan($id_pengaduan);
        $data['bukti'] = $this->M_ekskul->getBuktiByPengaduan($id_pengaduan);

        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Pengaduan.');

        echo view('/admin/header', $hee);
        echo view('/pengaduan/chat', $data);
        echo view('/admin/footer');
    }
    public function tindak($id_pengaduan)
{
    $level = session()->get('level');

    // hanya admin & kesiswaan
    if (!in_array($level, ['1','4'])) {
        return redirect()->back();
    }

    $this->M_ekskul->edit('pengaduan', [
        'status' => 'Ditindak Kesiswaan'
    ], [
        'id_pengaduan' => $id_pengaduan
    ]);

return redirect()->to(previous_url())
    ->with('success', 'Pengaduan ditindak kesiswaan');
}

public function selesai($id_pengaduan)
{
    $level = session()->get('level');

    if (!in_array($level, ['1','4'])) {
        return redirect()->back();
    }

    $this->M_ekskul->edit('pengaduan', [
        'status' => 'Selesai'
    ], [
        'id_pengaduan' => $id_pengaduan
    ]);

return redirect()->back()
    ->with('success', 'Pengaduan selesai');
}

public function laporanBulanan()
{
    $bulan     = $this->request->getGet('bulan');
    $tahun     = $this->request->getGet('tahun');
    $id_rombel = $this->request->getGet('id_rombel'); // 🔥 tambahan

    if (!$bulan || !$tahun) {
        return redirect()->back()->with('error', 'Bulan & Tahun wajib diisi');
    }

    // 🔥 pengaduan + filter rombel
    $data['pengaduan'] = $this->M_ekskul
    ->getPengaduanByBulanRombel($bulan, $tahun, $id_rombel);

    $data['totalSiswa'] = $this->M_ekskul
    ->countSiswaByBulanRombel($bulan, $tahun, $id_rombel);
    
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
$db = \Config\Database::connect();
    // nama rombel (judul laporan)
    if ($id_rombel) {
        $rombel = $db->table('rombel')
            ->where('id_rombel', $id_rombel)
            ->get()
            ->getRow();
        $data['nama_rombel'] = $rombel ? $rombel->nama_rombel : '-';
    } else {
        $data['nama_rombel'] = 'SEMUA ROMBEL';
    }

    // render HTML
    $html = view('laporan_pdf', $data);

    // PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream(
        "laporan_pengaduan_{$bulan}_{$tahun}.pdf",
        ['Attachment' => false]
    );
}

public function kirimChat()
{
    $level   = session()->get('level');
    $id_user = session()->get('id');

    if ($level != '4') {
        return redirect()->back();
    }

    $id_pengaduan = $this->request->getPost('id_pengaduan');
    $pesan        = $this->request->getPost('pesan');

    // simpan chat
    $this->M_ekskul->insertChat([
        'id_pengaduan' => $id_pengaduan,
        'id_user'      => $id_user,
        'pesan'        => $pesan,
        'created_at'   => date('Y-m-d H:i:s')
    ]);

    // upload foto (optional)
    $file = $this->request->getFile('file');
    if ($file && $file->isValid()) {
        $namaFile = $file->getRandomName();
        $file->move('assets/img/bukti', $namaFile);

        $this->M_ekskul->insertBukti([
            'id_pengaduan' => $id_pengaduan,
            'id_kesiswaan' => $id_user,
            'file'         => $namaFile,
            'created_at'   => date('Y-m-d H:i:s')
        ]);
    }

return redirect()->to(previous_url())
    ->with('success', 'Chat Terkirim');
    }


    public function reset_password($id)
    {
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan.');
            return redirect()->to('user');
        }

        $username = $user['username'];
        $newPassword = MD5($username);

        $userModel->update($id, ['password' => $newPassword]);

        log_activity(session()->get('id'), "Reset password user: $id");

        session()->setFlashdata('success', 'Password berhasil direset ke username.');
        return redirect()->to('user');
    }

    public function log () {

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
		$logModel = new M_log(); 
		if ($level == 1) {
        $hehe['love'] = $this->M_ekskul->log();
		if ($level === '1' || $level === '2' || $level === '3' || $level === '4' ) {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
		log_activity($id_user, 'Mengakses data Log.');
        echo view('/admin/header', $hee);
        echo view('/user/log', $hehe);
        echo view('/admin/footer');
    }}

    public function session()
{
    $level   = session()->get('level');
    $id_user = session()->get('id');

    $db = \Config\Database::connect();

    // menu
    $menu_all = $db->table('menu')
        ->orderBy('parent_id', 'ASC')
        ->orderBy('id_menu', 'ASC')
        ->get()
        ->getResultArray();

    // privileges
    $privs = $db->table('privileges')
        ->where('id_level', $level)
        ->get()
        ->getResultArray();

    $privileges = [];
    foreach ($privs as $p){
        $privileges[$p['id_menu']] = true;
    }

    $hee['menu_all']   = $menu_all;
    $hee['privileges'] = $privileges;

    // profile
    if (in_array($level, [1,2,3,4])) {
        $hee['prof'] = $this->M_ekskul->profile();
    } else {
        $hee['prof'] = null;
    }

    // log (PAKAI MODEL YANG BENAR)
    $logModel = new M_log();
    $hehe['love'] = $this->M_ekskul->logsession();

    log_activity($id_user, 'Mengakses data Log');

    echo view('/admin/header', $hee);
    echo view('/user/log', $hehe);
    echo view('/admin/footer');
}

}