<?php

namespace App\Controllers;
use App\Models\M_ekskul;

class Pendaftaran extends BaseController
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

        $siswa = $this->db->table('siswa')
            ->where('id_user', $id_user)
            ->get()
            ->getRow();

        $jumlahEkskul = 0;

        if ($siswa) {
            $jumlahEkskul = $this->db->table('pendaftaran')
                ->where('id_siswa', $siswa->id_siswa)
                ->countAllResults();
        }

        $hehe['love'] = $this->M_ekskul->siswapendaftaran();
        $data = [
            'love' => $this->M_ekskul->siswapendaftaran(),
            'jumlahEkskul' => $jumlahEkskul
        ];
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/pendaftaran/pendaftaran', $data);
        echo view('/admin/footer');
    }
    

    public function indexapprove () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');
        $hehe['love'] = $this->M_ekskul->pendaftaran();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/pendaftaran/pendaftaranapprove', $hehe);
        echo view('/admin/footer');
    }

    public function approve($id_pendaftaran)
    {
        $id_user = session()->get('id'); // user yang menyetujui

        $this->db->table('pendaftaran')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->update([
                'status' => 'Disetujui',
                'disetujui_oleh' => $id_user
            ]);

        session()->setFlashdata('success', 'Pendaftaran berhasil disetujui');
        return redirect()->back();
    }

    public function reject($id_pendaftaran)
    {
        $id_user = session()->get('id'); // user yang menolak

        $this->db->table('pendaftaran')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->update([
                'status' => 'Ditolak',
                'disetujui_oleh' => $id_user
            ]);

        session()->setFlashdata('error', 'Pendaftaran ditolak');
        return redirect()->back();
    }

    // public function edit ($id) {
    //     $level = $this->session->get('level');
    //     $id_user = $this->session->get('id');

    //     $hehe['ekskul'] = $this->M_ekskul->ekskul();
        
    //     $where = ['pendaftaran.id_pendaftaran' => $id];
    //     $hehe['love'] = $this->M_ekskul->jpendaftaran($where);
        
    //     if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
    //             $where = ['user.id_user' => $id_user];
    //             $hee['prof'] = $this->M_ekskul->profile();
    //         } else {
    //             $hee['prof'] = null;
    //         }
    //     echo view('/admin/header', $hee);
    //     echo view('/pendaftaran/editpendaftaran', $hehe);
    //     echo view('/admin/footer');
    // }

    // public function editsave()
    // {
    //     $request = service('request');
    //     $id = $request->getPost('id');
    //     $aktif = $this->request->getPost('aktif') ? 1 : 0;

    //     $dataAlumni = [
    //         'id_siswa' => $request->getPost('siswa'),
    //         'hari' => $request->getPost('hari'),
    //         'aktif' => $aktif,
    //         'jam_mulai' => $request->getPost('mulai'),
    //         'jam_selesai' => $request->getPost('selesai'),
    //     ];

    //     $whereAlumni = ['id_jadwal' => $id];
    //     $this->M_ekskul->edit('jadwal', $dataAlumni, $whereAlumni);

    //     return redirect()->to('jadwal');
    // }

    public function hapus($id_alumni)
    {
        $result = $this->M_ekskul->hapus('pendaftaran', ['id_pendaftaran' => $id_alumni]);

        if ($result) {
            session()->setFlashdata('success', 'pendaftaran berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'pendaftaran tidak ditemukan');
        }

        return redirect()->to('pendaftaran');
    }

    public function input () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');
        
        $hehe['jadwal'] = $this->M_ekskul->pilihjadwal();
        
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }
        echo view('/admin/header', $hee);
        echo view('/pendaftaran/inputpendaftaran', $hehe);
        echo view('/admin/footer');
    }
public function inputsave()
{
    $id_user = session()->get('id');

    // ambil id_siswa dari tabel siswa
    $siswa = $this->db->table('siswa')
        ->where('id_user', $id_user)
        ->get()
        ->getRow();

    // jaga-jaga kalau bukan siswa
    if (!$siswa) {
        return redirect()->back()->with('error', 'Akun ini bukan siswa.');
    }

    // cek jumlah ekskul yang sudah didaftarkan
    $jumlah = $this->db->table('pendaftaran')
        ->where('id_siswa', $siswa->id_siswa)
        ->countAllResults();

    // batas 4 ekskul
    if ($jumlah >= 4) {
        return redirect()->back()->with('error', 'Batas maksimal 4 ekskul sudah tercapai.');
    }

    // simpan kalau masih < 4
    $data = [
        'id_siswa'  => $siswa->id_siswa,
        'id_jadwal' => $this->request->getPost('jadwal'),
        'status'    => 'Menunggu Persetujuan'
    ];

    $this->M_ekskul->input('pendaftaran', $data);

    return redirect()->to(base_url('pendaftaran'))->with('success', 'Pendaftaran ekskul berhasil.');
}



}