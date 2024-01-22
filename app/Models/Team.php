<?php

namespace App\Models;

use App\Models\Surveyor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function Surveyor()
    {
        return $this->hasMany(related:Surveyor::class);
    }

}
