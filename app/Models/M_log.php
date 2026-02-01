<?php

namespace App\Models;

use CodeIgniter\Model;

class M_log extends Model
{
    protected $table            = 'log';
    protected $primaryKey       = 'id_log';
    protected $allowedFields    = ['id_user', 'activity', 'ip_address', 'created_at'];
    protected $useTimestamps    = false;

    public function saveLog($data)
    {
        return $this->insert($data);
    }

    public function getLogs()
    {
        return $this->db->table($this->table)
            ->select('log.*, user.username')
            ->join('user', 'user.id_user = log.id_user')
            ->orderBy('log.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getAllLogs()
    {
        $builder = $this->db->table($this->table);
        $query = $builder
            ->select('log.*, user.nama as nama_user, user.username')
            ->join('user', 'user.id_user = log.id_user', 'left')
            ->orderBy('log.created_at', 'DESC')
            ->get();

        if ($query->getNumRows() === 0) {
            return [];
        }

        return $query->getResultArray();
    }

    public function getLogsByUser($id_user)
    {
        return $this->where('id_user', $id_user)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function hasLoginActivity($id_user)
    {
        return $this->where('id_user', $id_user)
                    ->like('activity', 'login')
                    ->countAllResults() > 0;
    }
}
