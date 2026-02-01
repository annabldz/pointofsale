<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Kelas extends BaseController
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

        $hehe['love'] = $this->M_ekskul->kelas();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        
            log_activity($id_user, 'Mengakses halaman Kelas.');

        echo view('/admin/header', $hee);
        echo view('/kelas/kelas', $hehe);
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
        
        $where = ['id_kelas' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('kelas', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Edit Kelas.');

        echo view('/admin/header', $hee);
        echo view('/kelas/editkelas', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');

        $dataAlumni = [
            'nama_kelas' => $request->getPost('nama'),
        ];

        $whereAlumni = ['id_kelas' => $id];
        $this->M_ekskul->edit('kelas', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit kelas: {$dataAlumni['nama_kelas']}");

        return redirect()->to('kelas');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('kelas', ['id_kelas' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'kelas berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'kelas tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus kelas ID: $id_alumni");


        return redirect()->to('kelas');
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
        
        $hehe['kelas'] = $this->M_ekskul->kelas();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Input Kelas.');

        echo view('/admin/header', $hee);
        echo view('/kelas/inputkelas', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

        $userData = [
            'nama_kelas' => $this->request->getPost('nama'),
        ];

        $success = $this->M_ekskul->input('kelas', $userData);

        log_activity(session()->get('id'), "Mengedit kelas: {$userData['nama_kelas']}");

        return redirect()->to(base_url('kelas'));
    }

}