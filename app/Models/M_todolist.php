<?php

namespace App\Models;
use CodeIgniter\Model;

	
class M_todolist extends Model
{
	protected $table = 'task';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama','status','prioritas','tanggal'];

	public function tampil($table,$by){
		return $this->db->table($table)
						->orderby($by,'asc')
						->get()
						->getResult();
	}
	public function getSummaryTask()
	{
		return $this->db->query("
			SELECT
				COUNT(*) AS total_task,
				SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) AS task_selesai,
				SUM(CASE WHEN status = 'belum selesai' THEN 1 ELSE 0 END) AS task_belum_selesai
			FROM task
		")->getRowArray();
	}

	
	public function todolistdone(){
		return $this->db->table('task')	
                    ->where('Status', 'Selesai')
					->get()
					->getResult();
	}

    public function todolistnotdone(){
		return $this->db->table('task')	
                    ->where('Status', 'Belum Selesai')
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