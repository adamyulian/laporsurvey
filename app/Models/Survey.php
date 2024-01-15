<?php

namespace App\Models;

use App\Models\User;
use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;

    protected $casts = [
        'foto' => 'array',
        'nama' => 'array'
    ];

    protected $fillable = [
            'target_id',
            'user_id',
            'status',
            'nama',
            'foto',
            'nama_pic',
            'no_hp_pic',
            'hubungan_hukum',
            'dokumen_hub_hukum',
            'detail',
            'team_id'
    ];

    protected static function booted() {
        static::creating(function($model) {
            $model->user_id = Auth::user()->id;
            $model->team_id = Auth::user()->team->id;
            $cekRegister = Target::where('id', $model->target_id)->first();
            $cekRegister->update([
                'user_id' => $model->user_id
            ]);
        });
    }

    public function Target()
    {
        return $this->belongsTo(related:Target::class);
    }
    public function User()
    {
        return $this->belongsTo(related:User::class);
    }
}
