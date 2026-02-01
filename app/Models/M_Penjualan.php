<?php
namespace App\Models;
use CodeIgniter\Model;

class M_Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $allowedFields = ['tanggal','total','created_by'];

    public function insertDetail($id_penjualan, $id_barang, $jumlah, $harga)
    {
        $db = \Config\Database::connect();
        $subtotal = $jumlah * $harga;
        $db->table('penjualan_detail')->insert([
            'id_penjualan'=>$id_penjualan,
            'id_barang'=>$id_barang,
            'jumlah'=>$jumlah,
            'harga'=>$harga,
            'subtotal'=>$subtotal
        ]);
    }
}
