<?php

namespace App\Models;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penggunaan',
        'survey_id',
        'luas'
    ];

    protected static function booted() {
        static::creating(function($model) {
            $survey = Survey::find($surveyId);

            if ($survey->details->count() > 0) {
                $survey->update(['status' => 1]);
            }
        });
    }

    public function Survey()
    {
        return $this->belongsTo(related:Survey::class);
    }
}
