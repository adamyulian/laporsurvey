<?php

namespace App\Models;

use App\Models\User;
use App\Models\Target2;
use App\Models\Targetkendaraan;
use Illuminate\Support\Facades\Auth;
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
        'speedometer',
           'kebersihan',
           'ket_speedometer',
           'ket_kebersihan',
           'ket_tempat_duduk',
           'ket_dashboard',
           'ket_ac',
           'ket_kaca_film',
           'ket_toolkit',
           'ket_body',
           'ket_cat',
           'ket_lampu_utama',
           'ket_lampu_sein_depan',
           'ket_lampu_sein_blkg',
           'ket_lampu_rem',
           'ket_ban_mobil',
           'ket_ban_serep',
           'ket_klakson',
           'ket_wiper',
           'ket_spion',
           'ket_mesin',
           'ket_accu',
           'ket_rem',
           'ket_transmisi',
           'ket_power_steering',
           'ket_radiator',
           'ket_oli_mesin',
           'gambar_speedometer',
        'target2_id'

        ];
        
        protected static function booted() {
            static::creating(function($model) {
                $model->user_id = Auth::user()->id;
                $cekTarget = Target2::where('id', $model->target2_id)->first();
                $cekTarget->update([
                    'status' => 1
                ]);
            });
            static::deleting(function ($model) {
                // Assuming there is a 'target_id' attribute in the model
                $target = Target2::where('id', $model->target2_id)->first();
        
                if ($target) {
                    $target->update([
                        'status' => 0
                    ]);
                }
            });
        }

    public function Target2()
    {
        return $this->belongsTo(related:Target2::class);
    }

    public function User()
    {
        return $this->belongsTo(related:User::class);
    }
}
