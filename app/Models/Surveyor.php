<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveyor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'team_id'
     ];

     public function Team()
    {
        return $this->belongsTo(related:Team::class);
    }
}
