<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class User extends BaseController
{
 	protected $session;
    protected $M_ekskul;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_ekskul = new M_ekskul(); 
        $this->db = \Config\Database::connect();
		helper(['url', 'log', 'auth']);

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
        
        if (is_superadmin()) {
    // superadmin lihat semua
    $hehe['love'] = $this->M_ekskul->user();
} else {
    // admin biasa TIDAK lihat superadmin
    $hehe['love'] = $this->M_ekskul->userWithoutRoot();
}

        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman User.');

        echo view('/admin/header', $hee);
        echo view('/user/user', $hehe);
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
        $hehe['love'] = $this->M_ekskul->userdelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted User.');

        echo view('/admin/header', $hee);
        echo view('/user/deleted', $hehe);
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

        if (is_superadmin()) {
    $hehe['level'] = $this->M_ekskul->level();
} else {
    $hehe['level'] = $this->M_ekskul->levelWithoutAdmin();
}

        
        $where = ['user.id_user' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('user', 'level', 'user.level=level.id_level', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit User.');
        echo view('/admin/header', $hee);
        echo view('/user/edituser', $hehe);
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

            $userLama = $this->M_ekskul->getWhere('user', ['id_user' => $id]);
            if ($userLama && $userLama->foto && file_exists('assets/img/' . $userLama->foto)) {
                unlink('assets/img/' . $userLama->foto);
            }
        }

        $dataAlumni = [
            'nama' => $request->getPost('nama'),
            'username' => $request->getPost('username'),
            'level' => $request->getPost('level'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        if ($namaFileFoto) {
            $dataAlumni['foto'] = $namaFileFoto;
        }

        $whereAlumni = ['id_user' => $id];
        $this->M_ekskul->edit('user', $dataAlumni, $whereAlumni);
        
        log_activity(session()->get('id'), "Mengedit user: {$dataAlumni['nama']}");

        return redirect()->to('user');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('user', ['id_user' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'User berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'User tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus user ID: $id_alumni");


        return redirect()->to('user');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softDelete($id_alumni);
        log_activity(session()->get('id'), "Menghapus data user dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'User berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'User tidak ditemukan');
        }

        return redirect()->to('user/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restore($id_alumni);
        log_activity(session()->get('id'), "Merestore data user dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'User berhasil direstore');
        } else {
            session()->setFlashdata('error', 'User tidak ditemukan');
        }

        return redirect()->to('user');
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
        
        if (is_superadmin()) {
    $hehe['level'] = $this->M_ekskul->level();
} else {
    $hehe['level'] = $this->M_ekskul->levelWithoutAdmin();
}

        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input User.');

        echo view('/admin/header', $hee);
        echo view('/user/inputuser', $hehe);
        echo view('/admin/footer');
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

        $userData = [
            'foto' => $filename,
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'level' => $this->request->getPost('level'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('user', $userData);
        log_activity(session()->get('id'), "Menambahkan user: {$userData['nama']}");

        return redirect()->to(base_url('user'));
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
		if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5' ) {
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