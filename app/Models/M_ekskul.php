<?php

namespace App\Models;
use CodeIgniter\Model;
	
class M_ekskul extends Model
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
                    ->where('user.isdelete', 0)
					->get()
					->getResult();
	}
	public function userWithoutRoot()
{
    $id = session()->get('id');

    return $this->db->table('user u')
        ->join('level l', 'u.level = l.id_level')
        ->where('u.level !=', 1)
		->where('u.isdelete', 0)
        ->orWhere('u.id_user', $id) // 🔥 TETAP TAMPILKAN DIRI SENDIRI
        ->get()
        ->getResult();
}
public function levelWithoutAdmin()
{
    return $this->db->table('level')
        ->where('id_level !=', 1)
        ->get()
        ->getResult();
}


    public function userdelete(){
		return $this->db->table('user')	
					->join('level', 'user.level=level.id_level')
                    ->where('user.isdelete', 1)
					->get()
					->getResult();
	}

	public function level(){
		return $this->db->table('level')	
                    ->where('level.isdelete', 0)
					->get()
					->getResult();
	}

    public function leveldelete(){
		return $this->db->table('level')	
                    ->where('level.isdelete', 1)
					->get()
					->getResult();
	}

    public function kategori(){
		return $this->db->table('kategori')	
                    ->where('kategori.isdelete', 0)
					->get()
					->getResult();
	}

    public function kategoridelete(){
		return $this->db->table('kategori')	
                    ->where('kategori.isdelete', 1)
					->get()
					->getResult();
	}

    public function metode(){
		return $this->db->table('metode')	
                    ->where('metode.isdelete', 0)
					->get()
					->getResult();
	}

    public function metodedelete(){
		return $this->db->table('metode')	
                    ->where('metode.isdelete', 1)
					->get()
					->getResult();
	}

	public function notasetting(){
		return $this->db->table('nota_setting')	
                    ->where('nota_setting.isdelete', 0)
					->get()
					->getResult();
	}

    public function notasettingdelete(){
		return $this->db->table('nota_setting')	
                    ->where('nota_setting.isdelete', 1)
					->get()
					->getResult();
	}


    public function barang(){
		return $this->db->table('barang')	
                    ->join('kategori', 'barang.id_kategori=kategori.id_kategori')
                    ->where('barang.isdelete', 0)
					->get()
					->getResult();
	}

    public function barangdelete(){
		return $this->db->table('barang')	
                    ->join('kategori', 'barang.id_kategori=kategori.id_kategori')
                    ->where('barang.isdelete', 1)
					->get()
					->getResult();
	}

	public function barangmasuk(){
		return $this->db->table('barang_masuk')	
                    ->join('barang', 'barang_masuk.id_barang=barang.id_barang')
                    ->where('barang_masuk.isdelete', 0)
					->get()
					->getResult();
	}

    public function barangmasukdelete(){
		return $this->db->table('barang_masuk')	
                    ->join('barang', 'barang_masuk.id_barang=barang.id_barang')
                    ->where('barang_masuk.isdelete', 1)
					->get()
					->getResult();
	}

	public function penjualan(){
		return $this->db->table('penjualan')	
                    ->join('user', 'penjualan.id_user=user.id_user')
					->join('nota', 'penjualan.id_nota=nota.id_nota')
                    ->where('penjualan.isdelete', 0)
					->get()
					->getResult();
	}

    public function penjualandelete(){
		return $this->db->table('penjualan')	
                    ->join('user', 'penjualan.id_user=user.id_user')
					->join('nota', 'penjualan.id_nota=nota.id_nota')
                    ->where('penjualan.isdelete', 1)
					->get()
					->getResult();
	}

	public function log(){
		return $this->db->table('log')
					->select('log.*, user.username')
					->join('user', 'user.id_user=log.id_user')
					->get()
					->getResult();
	}

	public function logsession()
	{
		$id_user = session()->get('id');

		return $this->db->table('log')
			->select('log.*, user.username')
			->join('user', 'user.id_user = log.id_user')
			->where('log.id_user', $id_user)
			->orderBy('log.created_at', 'DESC')
			->get()
			->getResult();
	}

    public function softDelete($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('user')
                	->where('id_user', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restore($id_alumni)
    {
        return $this->db->table('user')
               		->where('id_user', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }

    public function softlevel($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('level')
                	->where('id_level', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restorelevel($id_alumni)
    {
        return $this->db->table('level')
               		->where('id_level', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }
    public function softpenjualan($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('penjualan')
                	->where('id_penjualan', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restorepenjualan($id_alumni)
    {
        return $this->db->table('penjualan')
               		->where('id_penjualan', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }
    public function softkategori($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('kategori')
                	->where('id_kategori', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restorekategori($id_alumni)
    {
        return $this->db->table('kategori')
               		->where('id_kategori', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }

    public function softmetode($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('metode')
                	->where('id_metode', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restoremetode($id_alumni)
    {
        return $this->db->table('metode')
               		->where('id_metode', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }

	public function softbarang($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('barang')
                	->where('id_barang', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restorebarang($id_alumni)
    {
        return $this->db->table('barang')
               		->where('id_barang', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
    }

	public function softbarangmasuk($id_alumni)
    {
		$now = date('Y-m-d H:i:s');
        return $this->db->table('barang_masuk')
                	->where('id_masuk', $id_alumni)
                	->update([
						'isdelete'     => 1,
						'deleted_at' => $now,
                	]);
        return false;
    }

    public function restorebarangmasuk($id_alumni)
    {
        return $this->db->table('barang_masuk')
               		->where('id_masuk', $id_alumni)
                	->update([
						'isdelete'     => 0,
						'deleted_at' => null,
                	]);
        return false;
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