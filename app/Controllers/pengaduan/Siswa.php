<?php

namespace App\Controllers;

use App\Models\M_ekskul;
use App\Models\M_log;

class Siswa extends BaseController
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

        $hehe['love'] = $this->M_ekskul->siswa();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Siswa.');

        echo view('/admin/header', $hee);
        echo view('/siswa/siswa', $hehe);
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

        $hehe['rombel'] = $this->M_ekskul->rombel();
        
        $where = ['siswa.id_siswa' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere2('siswa', 'user', 'rombel', 'siswa.id_user=user.id_user', 'siswa.id_rombel=rombel.id_rombel', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Siswa.');

        echo view('/admin/header', $hee);
        echo view('/siswa/editsiswa', $hehe);
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

        $dataSiswa = [
            'nis'         => $request->getPost('nis'),
            'id_rombel'   => $request->getPost('rombel'),
        ];
        $this->M_ekskul->edit('siswa', $dataSiswa, ['id_siswa' => $id]);

        $dataUser = [
            'username'    => $request->getPost('username'),
            'nama'        => $request->getPost('nama'),
        ];

        if ($namaFileFoto) {
            $dataUser['foto'] = $namaFileFoto;
        }

        $this->M_ekskul->edit('user', $dataUser, ['id_user' => $idUser]);

        log_activity(session()->get('id'), "Mengedit siswa: {$dataUser['nama']}");

        return redirect()->to('siswa');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('siswa', ['id_siswa' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'siswa berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'siswa tidak ditemukan');
        }

        log_activity(session()->get('id'), "Menghapus siswa ID: $id_alumni");


        return redirect()->to('siswa');
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

        log_activity($id_user, 'Mengakses halaman Input Siswa.');

        echo view('/admin/header', $hee);
        echo view('/siswa/inputsiswa', $hehe);
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
            'level' => 2,
        ];

        $id_user = $this->M_ekskul->input('user', $userData);

        $siswaData = [
            'id_user' => $id_user,
            'nis' => $this->request->getPost('nis'),
            'id_rombel' => $this->request->getPost('rombel'), // disesuaikan
        ];

        $this->M_ekskul->input('siswa', $siswaData);

        log_activity(session()->get('id'), "Menambahkan siswa: {$userData['nama']}");


        return redirect()->to(base_url('siswa'));
    }
}
