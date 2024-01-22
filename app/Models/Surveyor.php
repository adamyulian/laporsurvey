<?php

namespace App\Models;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function Survey()
    {
        return $this->hasMany(related:Survey::class);
    }
}
