<?php

namespace App\Controllers;

use App\Models\M_ekskul;
use App\Models\M_log;

class Guru extends BaseController
{
    protected $M_ekskul;
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->M_ekskul = new M_ekskul();

        $this->session = session();
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
        $hehe['love'] = $this->M_ekskul->guru();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Guru.');

        echo view('/admin/header', $hee);
        echo view('/guru/guru', $hehe);
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
        
        $where = ['guru.id_guru' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('guru', 'user', 'guru.id_user=user.id_user', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Edit Guru.');

        echo view('/admin/header', $hee);
        echo view('/guru/editguru', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $idUser = $request->getPost('id_user');
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

        $dataguru = [
            'nik'         => $request->getPost('nik'),
        ];
        $this->M_ekskul->edit('guru', $dataguru, ['id_guru' => $id]);

        $dataUser = [
            'username'    => $request->getPost('username'),
            'nama'        => $request->getPost('nama'),
        ];

        if ($namaFileFoto) {
            $dataUser['foto'] = $namaFileFoto;
        }

        $this->M_ekskul->edit('user', $dataUser, ['id_user' => $idUser]);

        log_activity(session()->get('id'), "Mengedit guru: {$dataUser['nama']}");

        return redirect()->to('guru');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('guru', ['id_guru' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'guru berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'guru tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus guru ID: $id_alumni");

        return redirect()->to('guru');
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
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
    
        log_activity($id_user, 'Mengakses halaman Input Guru.');

        echo view('/admin/header', $hee);
        echo view('/guru/inputguru', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

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
            'level' => 3,
        ];

        $id_user = $this->M_ekskul->input('user', $userData);

        $siswaData = [
            'id_user' => $id_user,
            'nik' => $this->request->getPost('nik'),
        ];

        $this->M_ekskul->input('guru', $siswaData);

        log_activity(session()->get('id'), "Menambahkan guru: {$userData['nama']}");

        return redirect()->to(base_url('guru'));
    }
}
