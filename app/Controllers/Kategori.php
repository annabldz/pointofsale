<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Kategori extends BaseController
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

        $hehe['love'] = $this->M_ekskul->kategori();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Kategori.');

        echo view('/admin/header', $hee);
        echo view('/kategori/kategori', $hehe);
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

        $hehe['love'] = $this->M_ekskul->kategoridelete();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Deleted Kategori.');

        echo view('/admin/header', $hee);
        echo view('/kategori/deleted', $hehe);
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
        
        $where = ['id_kategori' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('kategori', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Edit Kategori.');

        echo view('/admin/header', $hee);
        echo view('/kategori/editkategori', $hehe);
        echo view('/admin/footer');
    }


    public function editsave()
    {
        $request = service('request');
        $session = session();

        $id = $request->getPost('id');
        $id_login = $session->get('id');

        $dataAlumni = [
            'nama_kategori' => $request->getPost('nama'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $id_login
        ];

        $whereAlumni = ['id_kategori' => $id];
        $this->M_ekskul->edit('kategori', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit kategori: {$dataAlumni['nama_kategori']}");

        return redirect()->to('kategori');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('kategori', ['id_kategori' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'kategori berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'kategori tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus kategori ID: $id_alumni");


        return redirect()->to('kategori');
    }

    public function soft($id_alumni)
    {
        $result = $this->M_ekskul->softkategori($id_alumni);
        log_activity(session()->get('id'), "Menghapus data kategori dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'kategori berhasil dihapus (soft delete)');
        } else {
            session()->setFlashdata('error', 'kategori tidak ditemukan');
        }

        return redirect()->to('kategori/deleted');
    }

    public function restore($id_alumni)
    {
        $result = $this->M_ekskul->restorekategori($id_alumni);
        log_activity(session()->get('id'), "Merestore data kategori dengan ID: " . $id_alumni);

        if ($result) {
            session()->setFlashdata('success', 'kategori berhasil direstore');
        } else {
            session()->setFlashdata('error', 'kategori tidak ditemukan');
        }

        return redirect()->to('kategori');
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
        log_activity($id_user, 'Mengakses halaman Input Kategori.');

        echo view('/admin/header', $hee);
        echo view('/kategori/inputkategori', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();
        $id_login = $session->get('id');

        $userData = [
            'nama_kategori' => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $id_login
        ];

        $success = $this->M_ekskul->input('kategori', $userData);

        log_activity(session()->get('id'), "Menambahkan kategori: {$userData['nama_kategori']}");

        return redirect()->to(base_url('kategori'));
    }
}