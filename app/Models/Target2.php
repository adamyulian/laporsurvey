<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'nama_penyelia'
        ];
}
