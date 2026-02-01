<?php

namespace App\Controllers;
use App\Models\M_ekskul;

class Nilai extends BaseController
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

        $ekskul = $this->M_ekskul->getEkskulInstruktur($id_user, $level);
       
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

       

    $data = [
        'ekskul_saya' => $ekskul
    ];

        echo view('/admin/header', $hee);
        echo view('/nilai/nilai', $data);
        echo view('/admin/footer');
    }
//     public function indexsiswa()
// {
//     $id_user = session()->get('id');

//     $db = \Config\Database::connect();

//     // Ambil id_siswa dari user
//     $siswa = $db->table('siswa')
//         ->join('user', 'siswa.id_user=user.id_user')
//         ->where('siswa.id_user', $id_user)
//         ->get()
//         ->getRow();

//     if (!$siswa) {
//         throw new \Exception("Siswa tidak ditemukan.");
//     }

//     $id_siswa = $siswa->id_siswa;

//     // Ambil ekskul yang diambil siswa
//     $ekskul_saya = $db->table('pendaftaran p')
//         ->join('jadwal j', 'p.id_jadwal = j.id_jadwal')
//         ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
//         ->where('p.id_siswa', $id_siswa)
//         ->select('e.id_ekskul, e.nama_ekskul, j.hari')
//         ->get()
//         ->getResult();

//     $data = [
//         'ekskul_saya' => $ekskul_saya,
//         'nama' => $siswa->nama
//     ];

//     // Jika ingin profile tetap ditampilkan untuk level tertentu
//     $level = session()->get('level');
//     if (in_array($level, ['1','2','3','4'])) {
//         $hee['prof'] = $this->M_ekskul->profile();
//     } else {
//         $hee['prof'] = null;
//     }

//     echo view('/admin/header', $hee);
//     echo view('/nilai/nilaisiswa', $data);
//     echo view('/admin/footer');
// }
public function indexsiswa () {
        $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $db = \Config\Database::connect();

    // Ambil id_siswa dari user
    $siswa = $db->table('siswa')
        ->join('user', 'siswa.id_user=user.id_user')
        ->where('siswa.id_user', $id_user)
        ->get()
        ->getRow();

    if (!$siswa) {
        throw new \Exception("Siswa tidak ditemukan.");
    }

    $id_siswa = $siswa->id_siswa;

    // Ambil ekskul yang diambil siswa
    $ekskul_saya = $db->table('pendaftaran p')
        ->join('jadwal j', 'p.id_jadwal = j.id_jadwal')
        ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
        ->where('p.id_siswa', $id_siswa)
        ->select('e.id_ekskul, e.nama_ekskul, j.hari')
        ->get()
        ->getResult();

        $mey['love'] = $db->table('nilai n')
    ->join('pendaftaran p', 'p.id_pendaftaran = n.id_pendaftaran')
    ->join('jadwal j', 'p.id_jadwal = j.id_jadwal')
    ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
    ->where('p.id_siswa', $id_siswa) // hanya ambil nilai siswa login
    ->select('n.nilai, e.nama_ekskul, e.id_ekskul')
    ->get()
    ->getResult();

       
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

       

    $data = [
    'love' => $mey['love']  // ambil langsung array hasil query
];


        echo view('/admin/header', $hee);
        echo view('/nilai/nilaisiswa', $data);
        echo view('/admin/footer');
    }
public function pdfsiswa($id_ekskul)
{
    $db = \Config\Database::connect();

    // Ambil id_user dari session
    $id_user = session()->get('id'); // pastikan session 'id' sudah di-set saat login

    // Ambil id_siswa berdasarkan id_user
    $siswa = $db->table('siswa')
        ->join('user', 'siswa.id_user=user.id_user')
        ->where('siswa.id_user', $id_user)
        ->get()
        ->getRow();


    if (!$siswa) {
        throw new \Exception("Siswa tidak ditemukan untuk user ini.");
    }

    $id_siswa = $siswa->id_siswa;

    // Ambil nilai sesuai siswa dan ekskul
    $data['nilai'] = $db->table('nilai n')
    ->join('pendaftaran p', 'p.id_pendaftaran = n.id_pendaftaran')
    ->join('jadwal j', 'p.id_jadwal = j.id_jadwal')
    ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
    ->where('e.id_ekskul', $id_ekskul)
    ->where('p.id_siswa', $id_siswa)
    ->select('n.nilai, e.nama_ekskul, e.id_ekskul')
    ->get()
    ->getResult();


    // Ambil nama siswa
    $data['nama'] = $siswa->nama; // <-- sesuaikan dengan kolom di DB


    // Load view HTML
    $html = view('nilai/pdfsiswa', $data);

    // Load Dompdf
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Stream PDF
    $dompdf->stream("nilai_ekskul.pdf", ["Attachment" => true]);
}

    public function simpan()
{
    $id_pendaftaran = $this->request->getPost('id_pendaftaran');
    $nilai           = $this->request->getPost('nilai');

    foreach ($id_pendaftaran as $i => $id) {

         $data = [
                 'id_pendaftaran' => $id,
            'nilai'          => $nilai[$i]
    ];}

    $this->M_ekskul->input('nilai', $data);
    

   return redirect()->to(base_url('nilai'))->with('success', 'Nilai berhasil disimpan');

}

public function list($id_ekskul)
{
    $data['siswa'] = $this->db->table('pendaftaran p')
        ->join('siswa s', 's.id_siswa = p.id_siswa')
        ->join('user u', 's.id_user=u.id_user')
        ->join('nilai n', 'n.id_pendaftaran = p.id_pendaftaran', 'left')
        ->join('jadwal j', 'p.id_jadwal=j.id_jadwal')
        ->where('j.id_ekskul', $id_ekskul)
        ->select('p.id_pendaftaran, u.nama, IFNULL(n.nilai, "-") as nilai')
        ->get()
        ->getResult();

    return view('nilai/list', $data);
}

public function siswa($id_ekskul)
{
    $siswa = $this->db->table('pendaftaran p')
        ->join('siswa s', 's.id_siswa = p.id_siswa')
        ->join('user u', 's.id_user=u.id_user')
        ->join('jadwal j', 'j.id_jadwal = p.id_jadwal')
        ->where('j.id_ekskul', $id_ekskul)
        ->get()
        ->getResult();

    return view('nilai/list_siswa', ['siswa' => $siswa]);
}

public function pdf($id_ekskul)
{
    $db = \Config\Database::connect();

    $data['nilai'] = $db->table('nilai n')
        ->join('pendaftaran p', 'p.id_pendaftaran = n.id_pendaftaran')
        ->join('jadwal j', 'p.id_jadwal=j.id_jadwal')
        ->join('siswa s', 's.id_siswa = p.id_siswa')
        ->join('user u', 's.id_user=u.id_user')
        ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
        ->where('e.id_ekskul', $id_ekskul)
        ->select('u.nama, e.nama_ekskul, n.nilai')
        ->get()
        ->getResult();

    // Load view HTML sebagai string
    $html = view('nilai/pdf', $data);

    // Load library Dompdf
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Stream PDF langsung ke browser sebagai file
    $dompdf->stream("nilai_ekskul.pdf", ["Attachment" => true]);
}

    // --------------------------
    // DETAIL ABSENSI PER TANGGAL
    // --------------------------
    public function detail($id_absensi)
    {
        $data['detail'] = $this->M_ekskul->getDetailAbsensi($id_absensi);

        return view('absensi/detail_modal', $data);
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

public function listSiswaWali()
{
    $db = \Config\Database::connect();

   $id_user = session()->get('id'); // id_user dari login

    // Ambil id_guru dari id_user
    $guru = $db->table('guru')->where('id_user', $id_user)->get()->getRow();
    if ($guru) {
        $id_guru = $guru->id_guru;

    // Ambil siswa berdasarkan rombel wali kelas
    $data['siswa'] = $db->table('siswa s')
        ->join('user', 's.id_user = user.id_user')

        ->join('rombel r', 's.id_rombel = r.id_rombel')
        ->join('kelas', 'r.id_kelas=kelas.id_kelas')
        ->join('jurusan', 'r.id_jurusan=jurusan.id_jurusan')
        ->where('r.id_guru', $id_guru)
        ->select('s.id_siswa, user.nama, s.nis, r.nama_rombel, kelas.nama_kelas, jurusan.nama_jurusan')
        ->get()
        ->getResult();
          } else {
        $data['siswa'] = []; // guru tidak ditemukan / tidak jadi wali
    }

         $level = $this->session->get('level');
        $id_user = $this->session->get('id');

        $ekskul = $this->M_ekskul->getEkskulInstruktur($id_user, $level);
       
        if ($level === '1' || $level === '2' || $level === '3' || $level === '4') {
                $where = ['user.id_user' => $id_user];
                $hee['prof'] = $this->M_ekskul->profile();
            } else {
                $hee['prof'] = null;
            }

       

    echo view('/admin/header', $hee);
    echo view('/nilai/siswawali', $data); // view daftar siswa
    echo view('/admin/footer');
}

// Ambil ekskul siswa (dipanggil via AJAX)
public function ekskulSiswa($id_siswa)
{
    $db = \Config\Database::connect();

    $data['ekskul'] = $db->table('pendaftaran p')
        ->join('jadwal j', 'p.id_jadwal = j.id_jadwal')
        ->join('ekskul e', 'e.id_ekskul = j.id_ekskul')
        ->where('p.id_siswa', $id_siswa)
        ->select('e.nama_ekskul, j.hari')
        ->get()
        ->getResult();

    echo view('nilai/modal_ekskul', $data); // view isi modal
}


}