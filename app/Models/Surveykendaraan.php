<?php

namespace App\Models;

use App\Models\Targetkendaraan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surveykendaraan extends Model
{
    use HasFactory;

    protected $casts = [
        'gambar_interior' => 'array',
        'gambar_eksterior' => 'array',
        'gambar_mesin' => 'array'
    ];

    protected $fillable = [
        'tempat_duduk',
        'dashboard',
        'ac',
        'kaca_film',
        'toolkit',
        'body',
        'cat',
        'lampu_utama',
        'lampu_sein_depan',
        'lampu_sein_blkg',
        'lampu_rem',
        'ban_mobil',
        'ban_serep',
        'klakson',
        'wiper',
        'spion',
        'mesin',
        'accu',
        'rem',
        'transmisi',
        'power_steering',
        'radiator',
        'oli_mesin',
        'gambar_interior',
        'gambar_eksterior',
        'gambar_mesin',
        'target_kendaraan_id'
        ];

        public function Targetkendaraan()
    {
        return $this->belongsTo(related:Targetkendaraan::class);
    }
}
