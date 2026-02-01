<?php
namespace App\Models;
use CodeIgniter\Model;

class M_Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['kode','nama_barang','id_kategori','harga','modal','stok','status','foto'];
    protected $returnType = 'object';


    public function getById($id)
{
    return $this->where('id_barang', $id)->first();
}

}
