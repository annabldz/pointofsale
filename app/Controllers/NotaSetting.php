<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class NotaSetting extends BaseController
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
        $hehe['love'] = $this->M_ekskul->notasetting();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Nota Setting.');

        echo view('/admin/header', $hee);
        echo view('/nota/setting', $hehe);
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

        $hehe['level'] = $this->M_ekskul->level();
        
        $where = ['id_notset' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('nota_setting', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Nota Setting.');
        echo view('/admin/header', $hee);
        echo view('/nota/editsetting', $hehe);
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
            'title' => $request->getPost('title'),
            'alamat' => $request->getPost('alamat'),
            'notelp' => $request->getPost('notelp'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        if ($namaFileFoto) {
            $dataAlumni['logo'] = $namaFileFoto;
        }

        $whereAlumni = ['id_notset' => $id];
        $this->M_ekskul->edit('nota_setting', $dataAlumni, $whereAlumni);
        
        log_activity(session()->get('id'), "Mengedit nota setting: {$dataAlumni['title']}");

        return redirect()->to('nota/setting');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('nota_setting', ['id_notset' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'User berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'User tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus user ID: $id_alumni");


        return redirect()->to('nota/setting');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softnotasetting($id_alumni);
        log_activity(session()->get('id'), "Menghapus data nota setting dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'nota setting berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'nota setting tidak ditemukan');
        }

        return redirect()->to('nota/setting/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorenotasetting($id_alumni);
        log_activity(session()->get('id'), "Merestore data nota setting dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'nota setting berhasil direstore');
        } else {
            session()->setFlashdata('error', 'nota setting tidak ditemukan');
        }

        return redirect()->to('nota/setting');
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
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Nota Setting.');

        echo view('/admin/header', $hee);
        echo view('/nota/inputsetting', $hehe);
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
            'logo' => $filename,
            'title' => $this->request->getPost('title'),
            'alamat' => $this->request->getPost('alamat'),
            'notelp' => $this->request->getPost('notelp'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('nota_setting', $userData);
        log_activity(session()->get('id'), "Menambahkan nota setting: {$userData['title']}");

        return redirect()->to(base_url('nota/setting'));
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