<?php

namespace App\Controllers;
use App\Models\M_ekskul;

class Jadwal extends BaseController
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
        $hehe['love'] = $this->M_ekskul->jadwal();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/jadwal/jadwal', $hehe);
        echo view('/admin/footer');
    }

    public function edit ($id) {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $hehe['ekskul'] = $this->M_ekskul->ekskul();
        
        $where = ['jadwal.id_jadwal' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('jadwal', 'ekskul', 'jadwal.id_ekskul=ekskul.id_ekskul', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/jadwal/editjadwal', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $aktif = $this->request->getPost('aktif') ? 1 : 0;

        $dataAlumni = [
            'id_ekskul' => $request->getPost('ekskul'),
            'hari' => $request->getPost('hari'),
            'aktif' => $aktif,
            'jam_mulai' => $request->getPost('mulai'),
            'jam_selesai' => $request->getPost('selesai'),
        ];

        $whereAlumni = ['id_jadwal' => $id];
        $this->M_ekskul->edit('jadwal', $dataAlumni, $whereAlumni);

        return redirect()->to('jadwal');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('jadwal', ['id_jadwal' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'jadwal berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'jadwal tidak ditemukan');
        }

        return redirect()->to('jadwal');
    }

    public function input () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');
        
        $hehe['ekskul'] = $this->M_ekskul->ekskul();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/jadwal/inputjadwal', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {
        $aktif = $this->request->getPost('aktif') ? 1 : 0;

        $userData = [
            'id_ekskul' => $this->request->getPost('ekskul'),
            'hari' => $this->request->getPost('hari'),
            'aktif' => $aktif,
            'jam_mulai' => $this->request->getPost('mulai'),
            'jam_selesai' => $this->request->getPost('selesai'),
        ];

        $this->M_ekskul->input('jadwal', $userData);

        return redirect()->to(base_url('jadwal'));
    }


}