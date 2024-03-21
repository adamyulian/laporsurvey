<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Databangunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_lokasi',
        'register_bangunan',
        'register_tanah',
        'nama_bangunan',
        'alamat_bangunan',
        'kode_barang',
        'luas_lantai',
        'luas_bangunan',
        'tahun_perolehan',
        'nilai',
        'keterangan'
    ];
}
