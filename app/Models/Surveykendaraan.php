<?php

namespace App\Models;

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
        'target_kendaraan_id'
        ];
        
        protected static function booted() {
            static::creating(function($model) {
                $model->user_id = Auth::user()->id;
                $model->team_id = Auth::user()->team->id;
                $cekTarget = Targetkendaraan::where('id', $model->target_kendaraan_id)->first();
                $cekTarget->update([
                    'status' => 1
                ]);
            });
            static::deleting(function ($model) {
                // Assuming there is a 'target_id' attribute in the model
                $target = Targetkendaraan::where('id', $model->target_kendaraan_id)->first();
        
                if ($target) {
                    $target->update([
                        'status' => 0
                    ]);
                }
            });
        }
        public function targetkendaraan()
    {
        return $this->belongsTo(related:Targetkendaraan::class);
    }
}
