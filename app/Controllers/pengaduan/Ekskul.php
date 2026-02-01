<?php

namespace App\Controllers;
use App\Models\M_ekskul;

class Ekskul extends BaseController
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
        $hehe['love'] = $this->M_ekskul->ekskul();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/ekskul/ekskul', $hehe);
        echo view('/admin/footer');
    }

    public function edit ($id) {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $hehe['guru'] = $this->M_ekskul->guru();
        
        $where = ['ekskul.id_ekskul' => $id];
        $hehe['love'] = $this->M_ekskul->jwhere1('ekskul', 'guru', 'ekskul.id_guru=guru.id_guru', $where);
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/ekskul/editekskul', $hehe);
        echo view('/admin/footer');
    }

    public function editsave()
    {
        $request = service('request');
        $id = $request->getPost('id');

        $dataAlumni = [
            'id_guru' => $request->getPost('guru'),
            'nama_ekskul' => $request->getPost('nama'),
        ];

        $whereAlumni = ['id_ekskul' => $id];
        $this->M_ekskul->edit('ekskul', $dataAlumni, $whereAlumni);

        return redirect()->to('ekskul');
    }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('ekskul', ['id_ekskul' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'ekskul berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'ekskul tidak ditemukan');
        }

        return redirect()->to('ekskul');
    }

    public function input () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');
        
        $hehe['guru'] = $this->M_ekskul->guru();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/ekskul/inputekskul', $hehe);
        echo view('/admin/footer');
    }

    public function inputsave()
    {

        $userData = [
            'id_guru' => $this->request->getPost('guru'),
            'nama_ekskul' => $this->request->getPost('nama'),
        ];

        $this->M_ekskul->input('ekskul', $userData);

        return redirect()->to(base_url('ekskul'));
    }

}