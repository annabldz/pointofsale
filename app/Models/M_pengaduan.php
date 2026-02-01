<?php

namespace App\Models;
use CodeIgniter\Model;
	
class M_pengaduan extends Model
{

	public function tampil($table,$by){
		return $this->db->table($table)
						->orderby($by,'asc')
						->get()
						->getResult();
	}

    public function profile(){
	$id = session()->get('id'); 

	return $this->db->table('user')
					->join('level', 'user.level=level.id_level', 'left')
					->where('user.id_user', $id)
					->get()
					->getRow();
	}
	
	public function user(){
		return $this->db->table('user')	
					->join('level', 'user.level=level.id_level')
					->get()
					->getResult();
	}

	public function menu(){
		return $this->db->table('menu')	
					->get()
					->getResult();
	}
	public function level(){
		return $this->db->table('level')	
					->get()
					->getResult();
	}

	public function kelas(){
		return $this->db->table('kelas')	
					->get()
					->getResult();
	}

	public function jurusan(){
		return $this->db->table('jurusan')	
					->get()
					->getResult();
	}
	public function siswa(){
		return $this->db->table('siswa')	
					->join('user', 'siswa.id_user=user.id_user')
					->join('rombel', 'siswa.id_rombel=rombel.id_rombel')
					->join('kelas', 'rombel.id_kelas=kelas.id_kelas')
					->join('jurusan', 'rombel.id_jurusan=jurusan.id_jurusan')
					->get()
					->getResult();
	}
	public function guru(){
		return $this->db->table('guru')	
					->join('user', 'guru.id_user=user.id_user')
					->get()
					->getResult();
	}
	public function jadwal(){
		return $this->db->table('jadwal')	
					->join('ekskul', 'jadwal.id_ekskul=ekskul.id_ekskul')
					->get()
					->getResult();
	}

	public function pilihjadwal(){
		return $this->db->table('jadwal')	
					->join('ekskul', 'jadwal.id_ekskul=ekskul.id_ekskul')
					->where('jadwal.aktif', 1)
					->get()
					->getResult();
	}

	// public function getEkskulInstruktur($id_user)
    // {
    //     return $this->db->table('ekskul e')
    //         ->join('guru', 'guru.id_guru = e.id_guru')
    //         ->join('user', 'user.id_user = guru.id_user')
    //         ->where('user.id_user', $id_user)
    //         ->select('e.*, user.nama')
    //         ->get()->getResult();
    // }

	public function getEkskulInstruktur($id_user, $level)
{
    $builder = $this->db->table('ekskul e')
        ->join('guru', 'guru.id_guru = e.id_guru')
        ->join('user', 'user.id_user = guru.id_user')
        ->select('e.*, user.nama');

    if ($level != '1') {
        // selain admin, filter sesuai id_user
        $builder->where('user.id_user', $id_user);
    }

    $ekskul = $builder->get()->getResult();

    foreach ($ekskul as $e) {
        $e->tanggal = $this->db->table('absensi a')
            ->select('a.tanggal, MIN(a.id_absensi) as id_absensi')
            ->join('pendaftaran p', 'p.id_pendaftaran = a.id_pendaftaran')
            ->join('jadwal j', 'j.id_jadwal = p.id_jadwal')
            ->where('j.id_ekskul', $e->id_ekskul)
            ->groupBy('a.tanggal')
            ->orderBy('a.tanggal', 'DESC')
            ->get()
            ->getResult();
    }

    return $ekskul;
}


    public function getDetailAbsensi($id_absensi)
    {
        return $this->db->table('absensi a')
            ->join('pendaftaran p', 'p.id_pendaftaran = a.id_pendaftaran')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('user u', 'u.id_user = s.id_user')
            ->where('a.id_absensi', $id_absensi)
            ->select('u.nama, a.keterangan, a.tanggal')
            ->get()->getResult();
    }
	public function getPesertaByEkskul($id_ekskul)
    {
        return $this->db->table('pendaftaran p')
            ->join('jadwal j', 'j.id_jadwal = p.id_jadwal')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('user u', 'u.id_user = s.id_user')
            ->where('j.id_ekskul', $id_ekskul)
            ->select('p.id_pendaftaran, u.nama')
            ->get()->getResult();
    }

	public function pendaftaran()
{
    return $this->db->table('pendaftaran p')
        ->select('p.*, user.nama, ekskul.nama_ekskul, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai, u2.nama as disetujui_nama')
        ->join('siswa', 'p.id_siswa = siswa.id_siswa')
        ->join('user', 'siswa.id_user = user.id_user')
        ->join('jadwal', 'p.id_jadwal = jadwal.id_jadwal')
        ->join('ekskul', 'jadwal.id_ekskul = ekskul.id_ekskul')
        ->join('user u2', 'u2.id_user = p.disetujui_oleh', 'left')   // ⬅ ini penting
        ->get()
        ->getResult();
}

public function absensiswa($id_user)
{
	$id_user = session()->get('id');

$id_siswa = $this->db->table('siswa')
    ->where('id_user', $id_user)
    ->get()
    ->getRow()
    ->id_siswa;

    return $this->db->table('absensi')
        ->join('pendaftaran', 'absensi.id_pendaftaran = pendaftaran.id_pendaftaran')
        ->join('jadwal', 'pendaftaran.id_jadwal = jadwal.id_jadwal')
        ->join('ekskul', 'jadwal.id_ekskul = ekskul.id_ekskul')
        ->where('pendaftaran.id_siswa', $id_siswa) // 🔥 INI KUNCINYA
        ->get()
        ->getResult();
}

public function siswapendaftaran()
{
    $id_user = session()->get('id');

    // ambil id_siswa berdasarkan id_user
    $siswa = $this->db->table('siswa')
        ->where('id_user', $id_user)
        ->get()
        ->getRow();

    return $this->db->table('pendaftaran p')
        ->select('p.*, user.nama, ekskul.nama_ekskul, jadwal.hari, jadwal.jam_mulai, jadwal.jam_selesai, u2.nama as disetujui_nama')
        ->join('siswa', 'p.id_siswa = siswa.id_siswa')
        ->join('user', 'siswa.id_user = user.id_user')
        ->join('jadwal', 'p.id_jadwal = jadwal.id_jadwal')
        ->join('ekskul', 'jadwal.id_ekskul = ekskul.id_ekskul')
        ->join('user u2', 'u2.id_user = p.disetujui_oleh', 'left')
        ->where('p.id_siswa', $siswa->id_siswa)
        ->get()
        ->getResult();
}


	public function jpendaftaran($where){
		return $this->db->table('pendaftaran')
						->join('siswa', 'pendaftaran.id_siswa=siswa.id_siswa')
						->join('user', 'siswa.id_user=user.id_user')
						->join('jadwal', 'pendaftaran.id_jadwal=jadwal.id_jadwal')
						->join('ekskul', 'jadwal.id_ekskul=ekskul.id_ekskul')
						->where($where)
						->get()
						->getRow();
	}
	
	public function rombel(){
		return $this->db->table('rombel')
					->join('guru', 'rombel.id_guru=guru.id_guru')
					->join('user', 'guru.id_user=user.id_user')
					->join('kelas', 'rombel.id_kelas=kelas.id_kelas')
					->join('jurusan', 'rombel.id_jurusan=jurusan.id_jurusan')	
					->get()
					->getResult();
	}
	public function jrombel($where){
		return $this->db->table('rombel')
						->join('guru', 'rombel.id_guru=guru.id_guru')
						->join('user', 'guru.id_user=user.id_user')
						->join('kelas', 'rombel.id_kelas=kelas.id_kelas')
						->join('jurusan', 'rombel.id_jurusan=jurusan.id_jurusan')
						->where($where)
						->get()
						->getRow();
	}
	public function ekskul(){
		return $this->db->table('ekskul')	
					->join('guru', 'ekskul.id_guru=guru.id_guru')
					->join('user', 'guru.id_user=user.id_user')
					->get()
					->getResult();
	}

	public function hei($table,$by, $where){
		return $this->db->table($table)
						->orderby($by,'asc')
						->where($where)
						->get()
						->getResult();
	}
	public function join($table, $table2, $on){
		return $this->db->table($table)
						->join($table2,$on)
						->get()
						->getResult();
	}
	public function jwhere($table, $table2, $on,$where){
		return $this->db->table($table)
						->join($table2,$on)
						->where($where)
						->get()
						->getResult();
	}
	public function jwhere1($table, $table2, $on,$where){
		return $this->db->table($table)
						->join($table2,$on)
						->where($where)
						->get()
						->getRow();
	}

	public function jwhere2($table, $table2, $table3, $on, $on2, $where){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->where($where)
						->get()
						->getRow();
	}
	
	public function create($data){
		$query = $this->db->table($this->table)
						  ->insert($data);
						  return $query;
	}
	
	public function input($table, $data){
		 $this->db->table($table)
						->insert($data);
						return $this->db->insertID();
	}

	public function hapus($table, $where){
		return $this->db->table($table)
						->delete($where);
	}
	public function getWhere($table, $where){
		return $this->db->table($table)
						->getWhere($where)
						->getRow();
	}
	public function edit($table,$data,$where){
		return $this->db->table($table)
						->update($data,$where);
	}
	public function joinw($table, $table2, $on, $w){  
		return $this->db->table($table)
						->join($table2,$on)
						->where($w)
						->get()
						->getRow();
	}
	
}