<?php

namespace App\Controllers;
use App\Models\M_pengaduan;
use App\Models\M_log;

class Menu extends BaseController
{

 	protected $session;
    protected $M_pengaduan;
    protected $db;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->M_pengaduan = new M_pengaduan(); 
		helper(['url', 'log']);
        $this->db = \Config\Database::connect();
    }

    public function index () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $db = \Config\Database::connect();
        $logModel = new M_log(); 

        // ambil semua menu
        $menu_all = $this->db->table('menu')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('id_menu', 'ASC')
            ->get()
            ->getResultArray();

        // ambil privileges user
        $privs = $this->db->table('privileges')
            ->where('id_level', $level)
            ->get()
            ->getResultArray();

        $privileges = [];
        foreach($privs as $p){
            $privileges[$p['id_menu']] = true;
        }

        // passing ke view
        $hee['menu_all'] = $menu_all;
        $hee['privileges'] = $privileges;

        $data['level'] = $db->table('level')->where('isdelete', 0)->get()->getResultArray();
        $data['menu']  = $db->table('menu')->where('isdelete', 0)->get()->getResultArray();

        // ambil privileges
        $priv = $db->table('privileges')->where('isdelete', 0)->get()->getResultArray();

        // ubah jadi array map biar gampang cek checkbox
        $data['privileges'] = [];
        foreach ($priv as $p) {
            $data['privileges'][$p['id_level']][$p['id_menu']] = true;
        }
            
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_pengaduan->profile();
            } else {
                $hee['prof'] = null;
            }

            log_activity($id_user, 'Mengakses halaman Hak Akses Menu.');

        echo view('/admin/header', $hee);
        echo view('/menu', $data);
        echo view('/admin/footer', $hee);
    }
    public function data () {
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

        $hehe['love'] = $this->M_pengaduan->menu();
            
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_pengaduan->profile();
            } else {
                $hee['prof'] = null;
            }
        log_activity($id_user, 'Mengakses halaman Data Menu.');

        echo view('/admin/header', $hee);
        echo view('/menu/data', $hehe);
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
        
        $db = \Config\Database::connect();
        $hehe['menu_edit'] = $this->M_pengaduan->menu();
        $hehe['parent_menu'] = $db->table('menu')
        ->where('parent_id', NULL)
        ->get()
        ->getResultArray();
        $where = ['id_menu' => $id];
        $hehe['love'] = $this->M_pengaduan->getWhere('menu', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_pengaduan->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Edit Menu.');

        echo view('/admin/header', $hee);
        echo view('/menu/edit', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');

        $parent_id = $this->request->getPost('parent_id');
        $parent_id = $parent_id == '' ? NULL : $parent_id;
        $dataAlumni = [
            'nama_menu' => $this->request->getPost('nama'),
            'url'       => $this->request->getPost('url'),
            'icon'      => $this->request->getPost('icon'),
            'parent_id' => $parent_id
        ];

        $whereAlumni = ['id_menu' => $id];
        $this->M_pengaduan->edit('menu', $dataAlumni, $whereAlumni);

        log_activity(session()->get('id'), "Mengedit menu: {$dataAlumni['nama_menu']}");

        return redirect()->to('datamenu');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_pengaduan->hapus('menu', ['id_menu' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'menu berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'menu tidak ditemukan');
        }

        log_activity(session()->get('id'), activity: "Menghapus menu ID: $id_alumni");


        return redirect()->to('datamenu');
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
        $db = \Config\Database::connect();
        $hehe['menu'] = $this->M_pengaduan->menu();
        $hehe['parent_menu'] = $db->table('menu')
        ->where('parent_id', NULL)
        ->get()
        ->getResultArray();
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4' || $level === '5') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_pengaduan->profile();
            } else {
                $hee['prof'] = null;
            }

        log_activity($id_user, 'Mengakses halaman Input Menu.');

        echo view('/admin/header', $hee);
        echo view('/menu/input', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $session = session();

        $parent_id = $this->request->getPost('parent_id');
        $parent_id = $parent_id == '' ? NULL : $parent_id;

        $userData = [
            'nama_menu' => $this->request->getPost('nama'),
            'url'       => $this->request->getPost('url'),
            'icon'      => $this->request->getPost('icon'),
            'parent_id' => $parent_id
        ];
       
        $success = $this->M_pengaduan->input('menu', $userData);

        log_activity(session()->get('id'), "Menambahkan menu: {$userData['nama_menu']}");

        return redirect()->to(base_url('datamenu'));
    }

    public function save()
    {
        $request = $this->request->getJSON(true); // ambil JSON dari AJAX
        if(!$request){
            return $this->response->setJSON(['status'=>'error', 'msg'=>'Data kosong']);
        }

        // hapus semua privileges dulu supaya sync
        $this->db->table('privileges')->truncate();

        // insert privileges baru yang dicentang
        foreach($request as $d){
            if(isset($d['checked']) && $d['checked'] == 1){
                $this->db->table('privileges')->insert([
                    'id_level' => $d['level'],
                    'id_menu'  => $d['menu']
                ]);
            }
        }

        log_activity(
            session()->get('id'),
            'Mengubah hak akses menu (privileges)'
        );

        return $this->response->setJSON(['status'=>'success']);

        
    }
}