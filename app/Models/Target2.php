<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Target2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'nopol',
        'tahun',
        'merk',
        'tipe',
        'jabatan',
        'opd',
        'team_id',
        'nama_penyelia',
        'status',
        'user_id'
        ];

    public function Surveykendaraan()
        {
            return $this->hasMany(related:Surveykendaraan::class);
        }
        protected static function booted() {
            static::creating(function($model) {
                $model->user_id = Auth::user()->id;
                $model->nama_penyelia = Auth::user()->name;
                $model->status = '0';
            });
        }
    
}
