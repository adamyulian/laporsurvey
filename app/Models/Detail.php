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
        'luas',
        'kondisi',
        'foto_penggunaan',
        'hub_hukum'
    ];

    protected static function booted() {
        $alphabet = range('A', 'Z');
        static::creating(function ($model) use ($alphabet) {
            // Retrieve the parent survey and target information
            $survey = Survey::findOrFail($model->survey_id);
            $targetRegister = $survey->target->register;

            // Increment the child ID based on the count of existing child records
            $existingChildCount = $model->survey->detail()->count();
            $childIndex = $existingChildCount % count($alphabet);
            $childId = $alphabet[$childIndex];

            // Concatenate the parent register and child ID to generate the final ID
            $model->id_penggunaan = $targetRegister . '.' . $childId;
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
