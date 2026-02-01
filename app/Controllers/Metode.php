<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Metode extends BaseController
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

        $hehe['love'] = $this->M_ekskul->metode();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Metode.');

        echo view('/admin/header', $hee);
        echo view('/metode/metode', $hehe);
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

        $hehe['love'] = $this->M_ekskul->metodedelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Metode.');

        echo view('/admin/header', $hee);
        echo view('/metode/deleted', $hehe);
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
        
        $where = ['id_metode' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('metode', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Edit Metode.');

        echo view('/admin/header', $hee);
        echo view('/metode/editmetode', $hehe);
        echo view('/admin/footer');
    }


    public function editsave()
    {
        $request = service('request');
        $session = session();

        $id = $request->getPost('id');
        $id_login = $session->get('id');

        $dataAlumni = [
            'nama_metode' => $request->getPost('nama'),
            'kode' => $request->getPost('kode'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        $whereAlumni = ['id_metode' => $id];
        $this->M_ekskul->edit('metode', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit metode: {$dataAlumni['nama_metode']}");

        return redirect()->to('metode');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('metode', ['id_metode' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'metode berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'metode tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus metode ID: $id_alumni");


        return redirect()->to('metode');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softmetode($id_alumni);
        log_activity(session()->get('id'), "Menghapus data metode dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'metode berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'metode tidak ditemukan');
        }

        return redirect()->to('metode/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restoremetode($id_alumni);
        log_activity(session()->get('id'), "Merestore data metode dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'metode berhasil direstore');
        } else {
            session()->setFlashdata('error', 'metode tidak ditemukan');
        }

        return redirect()->to('metode');
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
        log_activity($id_user, 'Mengakses halaman Input Metode.');

        echo view('/admin/header', $hee);
        echo view('/metode/inputmetode', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();
        $id_login = $session->get('id');

        $userData = [
            'nama_metode' => $this->request->getPost('nama'),
            'kode' => $this->request->getPost('kode'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('metode', $userData);

        log_activity(session()->get('id'), "Menambahkan metode: {$userData['nama_metode']}");

        return redirect()->to(base_url('metode'));
    }
}