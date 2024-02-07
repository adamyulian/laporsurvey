<?php

namespace App\Models;

use App\Models\User;
use App\Models\Target2;
use App\Models\Targetkendaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surveykendaraan extends Model
{
    use HasFactory;

    protected $casts = [
        'gambar_interior' => 'array',
        'gambar_eksterior' => 'array',
        'gambar_mesin' => 'array'
    ];

    protected $fillable = [
        'tempat_duduk',
        'dashboard',
        'ac',
        'kaca_film',
        'toolkit',
        'body',
        'cat',
        'lampu_utama',
        'lampu_sein_depan',
        'lampu_sein_blkg',
        'lampu_rem',
        'ban_mobil',
        'ban_serep',
        'klakson',
        'wiper',
        'spion',
        'mesin',
        'accu',
        'rem',
        'transmisi',
        'power_steering',
        'radiator',
        'oli_mesin',
        'gambar_interior',
        'gambar_eksterior',
        'gambar_mesin',
        'speedometer',
           'kebersihan',
           'ket_speedometer',
           'ket_kebersihan',
           'ket_tempat_duduk',
           'ket_dashboard',
           'ket_ac',
           'ket_kaca_film',
           'ket_toolkit',
           'ket_body',
           'ket_cat',
           'ket_lampu_utama',
           'ket_lampu_sein_depan',
           'ket_lampu_sein_blkg',
           'ket_lampu_rem',
           'ket_ban_mobil',
           'ket_ban_serep',
           'ket_klakson',
           'ket_wiper',
           'ket_spion',
           'ket_mesin',
           'ket_accu',
           'ket_rem',
           'ket_transmisi',
           'ket_power_steering',
           'ket_radiator',
           'ket_oli_mesin',
           'gambar_speedometer',
        'target2_id',
        'kilometer',
        'merk_ban',
        'tahun_ban',
        'merk_accu',
        'masa_pajak',
        'informasi_tambahan',
        'lampu_kabut',
        'lampu_mundur',
        ];

        protected static function calculateGroupValues($model)
        {
            $groupValues = [];
            // Define mappings of field names to value mappings and weight factors for each group
            $groupMappings = [
                'group1' => [
                    'speedometer'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 20, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'kebersihan'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'tempat_duduk'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'dashboard'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'ac'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 20, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'kaca_film'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'toolkit'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 10, // Weight factor for the 'transmisi' field in group 1
                    ],
                ],
                'group2' => [
                    'body'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'cat'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_utama'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 10, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_sein_depan'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_sein_blkg'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_rem'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 10, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_kabut'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 2, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'lampu_mundur'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'ban_mobil'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 20, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'ban_serep'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'klakson'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 3, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'wiper'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 5, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'spion'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 10, // Weight factor for the 'transmisi' field in group 1
                    ],
                ],
                'group3' => [
                    'mesin'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'accu'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'rem'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'transmisi'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'power_steering'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 10, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'radiator'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                    'oli_mesin'=> [
                        'values' => [
                            'Baik' => 2,
                            'Kurang Baik' => 1,
                            'Rusak' => 0,
                        ],
                        'weightFactor' => 15, // Weight factor for the 'transmisi' field in group 1
                    ],
                ],
            ];

            // Define weight factors for each group
            $groupWeightFactors = [
                'group1' => 20, // Assuming group 1 has a maximum weight of 30%
                'group2' => 40, // Assuming group 2 has a maximum weight of 30%
                'group3' => 40, // Assuming group 2 has a maximum weight of 40%
                // Add weight factors for other groups here
            ];

            // Loop through each group to calculate total value
            foreach ($groupMappings as $groupName => $fieldMappings) {
                $groupTotalValue = 0;
                $fieldValues = [];
                foreach ($fieldMappings as $fieldName => $fieldData) {
                    $fieldValue = $model->$fieldName;
                    $fieldWeightFactor = $fieldData['weightFactor'];
                    $groupTotalValue += $fieldData['values'][$fieldValue] * ($fieldWeightFactor / 100);
                    $fieldValues[$fieldName] = $fieldValue;
                }
                // Store the total value, field values, and group weight factor for the group
                $groupValues[$groupName] = [
                    'totalValue' => $groupTotalValue,
                    'fieldValues' => $fieldValues,
                    'weightFactor' => $groupWeightFactors[$groupName],
                ];
            }

            return $groupValues;
        }
        // // Helper method to calculate the total value for all fields
        // protected static function calculateTotalFieldValue($model)
        // {
        //     $totalValue = 0;
        //     // Define mappings of field names to value mappings
        //     $fieldMappings = [
        //         'transmisi' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'ac' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'tempat_duduk' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'dashboard' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'kaca_film' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'toolkit' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'body' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'cat' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'lampu_utama' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'lampu_sein_depan' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'lampu_sein_blkg' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'lampu_rem' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'ban_mobil' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'ban_serep' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'klakson' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'wiper' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'spion' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'mesin' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'accu' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'rem' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'power_steering' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'radiator' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'oli_mesin' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'speedometer' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         'kebersihan' => [
        //             'Baik' => 2,
        //             'Kurang Baik' => 1,
        //             'Rusak' => 0,
        //         ],
        //         // Add mappings for other fields here
        //     ];

        //     // Loop through each field to calculate total value
        //     foreach ($fieldMappings as $fieldName => $valueMapping) {
        //         $fieldValue = $model->$fieldName;
        //         $totalValue += $valueMapping[$fieldValue];
        //     }

        //     return $totalValue;
        // }
        
        protected static function booted() {
            static::creating(function($model) {
                $model->user_id = Auth::user()->id;
                $cekTarget = Target2::where('id', $model->target2_id)->first();
                $cekTarget->update([
                    'status' => 1
                ]);
                // Calculate the total value for each field
                // $totalFieldValue = self::calculateTotalFieldValue($model);
                // $model->overall_total_value = $totalFieldValue;

                // Calculate the total value for each group and save individual field values
                $groupValues = self::calculateGroupValues($model);
                $overallTotalValue = 0;
                foreach ($groupValues as $groupName => $groupData) {
                    // Save the individual field values for the group
                    foreach ($groupData['fieldValues'] as $fieldName => $fieldValue) {
                        $model->$fieldName = $fieldValue;
                    }
                    // Save the total value for the group considering the weight factors of both the group and individual fields
                    $groupTotalValue = $groupData['totalValue'];
                    $groupWeightFactor = $groupData['weightFactor'];
                    $model->{$groupName . '_total_value'} = $groupTotalValue * ($groupWeightFactor / 100) * 50;
                    // Accumulate total value considering weight factors
                    $overallTotalValue += $groupTotalValue * ($groupWeightFactor / 100) * 50;
                }
                // Save the overall total value
                $model->overall_total_value = $overallTotalValue;
                    });
            static::deleting(function ($model) {
                // Assuming there is a 'target_id' attribute in the model
                $target = Target2::where('id', $model->target2_id)->first();
        
                if ($target) {
                    $target->update([
                        'status' => 0
                    ]);
                }
            });
        }

    public function Target2()
    {
        return $this->belongsTo(related:Target2::class);
    }

    public function User()
    {
        return $this->belongsTo(related:User::class);
    }
}
