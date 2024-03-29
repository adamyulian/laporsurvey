<?php

namespace App\Models;

use App\Models\Survey;
use App\Models\Databangunan;
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
        'hub_hukum',
        'id_penggunaan',
        'regbangunan'
    ];

    protected static function booted() {
        static::creating(function ($model) {
            $cekSurvey = Survey::where('id', $model->survey_id)->first();
            // $cekSurvey = Survey::find($model->survey_id);
            if ($cekSurvey) {
                $cekSurvey->update([
                    'jumlahdetail' => Detail::where('survey_id', $cekSurvey->id)->count() + 1
                ]);
            };

            // Retrieve the parent survey and target information
            $survey = Survey::findOrFail($model->survey_id);
            $targetRegister = $survey->target->register;

            // Mapping of 'function' options to alphabets
            $functionAlphabets = [
                'Rumah Ibadah' => 'A',
                'Bisnis/Komersial' => 'B',
                'Fasilitas Umum' => 'C',
                'Kantor' => 'D',
                'Ruang Terbuka Hijau' => 'E',
                'Taman' => 'F',
                'Rumah Tinggal' => 'G',
                'Sekolah' => 'H',
                'Balai RT/RW' => 'I',
                'Gedung Serbaguna' => 'J',
                'Tanah Kosong' => 'K',
                'Bangunan Kosong' => 'L',
                'Jalan' => 'M',
                'Sawah/Kebun' => 'N',
                'Tambak' => 'O',
                'Makam' => 'P'
            ];

            // Get the 'function' of the current model
            $function = $model->penggunaan;

            // Count the occurrences of the current function
            $functionCount = $survey->Detail()->where('penggunaan', $function)->count();

            // Get the corresponding alphabet for the function
            $alphabet = $functionAlphabets[$function];

            // Generate the final ID with alphabet and count
            $model->id_penggunaan = $targetRegister . '.' . $alphabet . ($functionCount + 1);

            // Update surveyor_id if details is null
            $survey = Survey::find($model->survey_id);
            if ($survey && $survey->details === null) {
                $survey->update(['surveyor_id' => '1']);
            }
        });
        static::updating(function ($model) {
            $survey = Survey::find($model->survey_id);
            if ($survey && $survey->details === null) {
                $jumlahdetail = $survey->Detail()->count();
                $survey->update([
                    'jumlahdetail' => Detail::where('survey_id', $survey->id)->count()
                ]);
            }
            $original = $model->getOriginal();
            if ($original['penggunaan'] !== $model->penggunaan) {
                 // Retrieve the parent survey and target information
            $survey = Survey::findOrFail($model->survey_id);
            $targetRegister = $survey->target->register;

            // Mapping of 'function' options to alphabets
            $functionAlphabets = [
                'Rumah Ibadah' => 'A',
                'Bisnis/Komersial' => 'B',
                'Fasilitas Umum' => 'C',
                'Kantor' => 'D',
                'Ruang Terbuka Hijau' => 'E',
                'Taman' => 'F',
                'Rumah Tinggal' => 'G',
                'Sekolah' => 'H',
                'Balai RT/RW' => 'I',
                'Gedung Serbaguna' => 'J',
                'Tanah Kosong' => 'K',
                'Bangunan Kosong' => 'L',
                'Jalan' => 'M',
                'Sawah/Kebun' => 'N',
                'Tambak' => 'O',
                'Makam' => 'P'
            ];

            // Get the 'function' of the current model
            $function = $model->penggunaan;

            // Count the occurrences of the current function
            $functionCount = $survey->Detail()->where('penggunaan', $function)->count();

            // Get the corresponding alphabet for the function
            $alphabet = $functionAlphabets[$function];

            // Generate the final ID with alphabet and count
            $model->id_penggunaan = $targetRegister . '.' . $alphabet . ($functionCount + 1);
            }

        });

        static::deleting(function ($model) {

            $survey = Survey::find($model->survey_id);
            if ($survey && $survey->details === null) {
                $survey->update([
                    'jumlahdetail' => Detail::where('survey_id', $survey->id)->count() - 1
                ]);
            }

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

    public function Databangunan()
    {
        return $this->belongsTo(related:Databangunan::class);
    }
}
