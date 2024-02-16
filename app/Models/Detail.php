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
        static::creating(function ($model) {
            // Retrieve the parent survey and target information
            $survey = Survey::findOrFail($model->survey_id);
            $targetRegister = $survey->target->register;
    
            // Get the count of existing child records related to the parent survey
            $existingChildCount = $model->survey->detail()->count();
    
            // Get the last used alphabet for this survey
            $lastUsedAlphabet = $survey->detail()->orderBy('id', 'desc')->value('id_penggunaan');
            $lastAlphabet = substr($lastUsedAlphabet, -1);
    
            // Find the next available alphabet in sequence
            $alphabet = range('a', 'z');
            $startIndex = array_search($lastAlphabet, $alphabet) + 1;
            $availableAlphabets = array_slice($alphabet, $startIndex);
            $childIndex = $existingChildCount % count($availableAlphabets);
            $childId = $availableAlphabets[$childIndex];
    
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
