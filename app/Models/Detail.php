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
        'detail',
        'luas'
    ];

    protected static function booted() {
        static::creating(function($model) {

            $survey = Survey::where('id', $model->survey_id)->first();
            if ($survey->details === null) {
                $survey->update(['surveyor_id' => '1']);
            }
        });    

        static::deleting(function ($model) {
            $survey = Survey::where('id', $model->survey_id)->first();

            if ($survey && $survey->details !== null && $survey->details->count() > 0) {
                // If details count is greater than 0, do not update surveyor_id
                return;
            }
    
            if ($survey) {
                $survey->update([
                    'surveyor_id' => 0
                ]);
            }
        });
    }

    public function Survey()
    {
        return $this->belongsTo(related:Survey::class);
    }
}
