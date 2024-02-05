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

            $survey = Survey::find($model->survey_id);

            if ($survey && $survey->details !== null && $survey->details->count() > 0) {
                $survey->update(['surveyor_id' => 1]);
            }
        });

        static::deleting(function ($model) {
            // Assuming there is a 'target_id' attribute in the model
            $survey = Survey::find($model->survey_id);
    
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
