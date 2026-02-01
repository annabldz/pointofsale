<?php

namespace App\Controllers;
use App\Models\M_ekskul;
use App\Models\M_log;

class Rombel extends BaseController
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

        $hehe['love'] = $this->M_ekskul->rombel();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Rombel.');

        echo view('/admin/header', $hee);
        echo view('/rombel/rombel', $hehe);
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

        $where = ['rombel.id_rombel' => $id];
        $hehe['love'] = $this->M_ekskul->jrombel($where);

        $hehe['guru'] = $this->M_ekskul->guru();
        $hehe['kelas'] = $this->M_ekskul->kelas();
        $hehe['jurusan'] = $this->M_ekskul->jurusan();

        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        
            log_activity($id_user, 'Mengakses halaman Edit Rombel.');

        echo view('/admin/header', $hee);
        echo view('/rombel/editrombel', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');

        $dataAlumni = [
            'id_guru' => $request->getPost('guru'),
            'id_kelas' => $request->getPost('id_kelas'),
            'id_jurusan' => $request->getPost('jurusan'),
            'nama_rombel' => $request->getPost('nama'),
        ];

        $whereAlumni = ['id_rombel' => $id];
        $this->M_ekskul->edit('rombel', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit rombel: {$dataAlumni['nama_rombel']}");

        return redirect()->to('rombel');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('rombel', ['id_rombel' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'rombel berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'rombel tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus rombel ID: $id_alumni");

        return redirect()->to('rombel');
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
        
        $hehe['rombel'] = $this->M_ekskul->rombel();
        $hehe['guru'] = $this->M_ekskul->guru();
        $hehe['kelas'] = $this->M_ekskul->kelas();
        $hehe['jurusan'] = $this->M_ekskul->jurusan();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Input Rombel.');

        echo view('/admin/header', $hee);
        echo view('/rombel/inputrombel', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

        $userData = [
            'id_guru' => $this->request->getPost('guru'),
            'id_kelas' => $this->request->getPost('kelas'),
            'id_jurusan' => $this->request->getPost('jurusan'),
            'nama_rombel' => $this->request->getPost('nama'),
        ];

        $success = $this->M_ekskul->input('rombel', $userData);

        log_activity(session()->get('id'), "Menambahkan rombel: {$userData['nama_rombel']}");

        return redirect()->to(base_url('rombel'));
    }
}