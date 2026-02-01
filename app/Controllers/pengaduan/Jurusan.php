<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Jurusan extends BaseController
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

        $hehe['love'] = $this->M_ekskul->jurusan();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Jurusan.');

        echo view('/admin/header', $hee);
        echo view('/jurusan/jurusan', $hehe);
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
        
        $where = ['id_jurusan' => $id];
        $hehe['love'] = $this->M_ekskul->getWhere('jurusan', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Jurusan.');

        echo view('/admin/header', $hee);
        echo view('/jurusan/editjurusan', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');

        $dataAlumni = [
            'nama_jurusan' => $request->getPost('nama'),
        ];

        $whereAlumni = ['id_jurusan' => $id];
        $this->M_ekskul->edit('jurusan', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit jurusan: {$dataAlumni['nama_jurusan']}");

        return redirect()->to('jurusan');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('jurusan', ['id_jurusan' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'jurusan berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'jurusan tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus jurusan ID: $id_alumni");

        return redirect()->to('jurusan');
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
        
        $hehe['jurusan'] = $this->M_ekskul->jurusan();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Input Jurusan.');

        echo view('/admin/header', $hee);
        echo view('/jurusan/inputjurusan', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

        $userData = [
            'nama_jurusan' => $this->request->getPost('nama'),
        ];

        $success = $this->M_ekskul->input('jurusan', $userData);

        log_activity(session()->get('id'), "Menambahkan jurusan: {$userData['nama_jurusan']}");

        return redirect()->to(base_url('jurusan'));
    }

}