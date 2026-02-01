<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Level extends BaseController
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

        $hehe['love'] = $this->M_ekskul->level();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Level.');

        echo view('/admin/header', $hee);
        echo view('/level/level', $hehe);
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

        $hehe['love'] = $this->M_ekskul->leveldelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Level.');

        echo view('/admin/header', $hee);
        echo view('/level/deleted', $hehe);
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
        
        $where = ['id_level' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('level', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Edit Level.');

        echo view('/admin/header', $hee);
        echo view('/level/editlevel', $hehe);
        echo view('/admin/footer');
    }


    public function editsave()
    {
        $request = service('request');
        $session = session();

        $id = $request->getPost('id');
        $id_login = $session->get('id');

        $dataAlumni = [
            'nama_level' => $request->getPost('nama'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        $whereAlumni = ['id_level' => $id];
        $this->M_ekskul->edit('level', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit level: {$dataAlumni['nama_level']}");

        return redirect()->to('level');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('level', ['id_level' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'level berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'level tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus level ID: $id_alumni");


        return redirect()->to('level');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softlevel($id_alumni);
        log_activity(session()->get('id'), "Menghapus data level dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'level berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'level tidak ditemukan');
        }

        return redirect()->to('level/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorelevel($id_alumni);
        log_activity(session()->get('id'), "Merestore data level dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'level berhasil direstore');
        } else {
            session()->setFlashdata('error', 'level tidak ditemukan');
        }

        return redirect()->to('level');
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
        log_activity($id_user, 'Mengakses halaman Input Level.');

        echo view('/admin/header', $hee);
        echo view('/level/inputlevel', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();
        $id_login = $session->get('id');

        $userData = [
            'nama_level' => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('level', $userData);

        log_activity(session()->get('id'), "Menambahkan level: {$userData['nama_level']}");

        return redirect()->to(base_url('level'));
    }
}