<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
           'nama',
           'register',
           'luas',
           'tahun_perolehan',
           'alamat',
           'penggunaan',
           'asal',
           'surveyor',
           'user_id'
    ];

    public function Team()
    {
        return $this->belongsTo(related:Team::class);
    }
}
