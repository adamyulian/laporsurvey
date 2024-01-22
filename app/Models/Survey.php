<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\Target;
use App\Models\Surveyor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;

    protected $casts = [
        'foto' => 'array',
        'nama' => 'array',
        'surveyor' => 'array'
    ];

    public function calculateHaversineDistance($location1, $location2)
    {
        // Radius of the Earth in meters.
        $earthRadius = 6371000;

        $lat1 = deg2rad($location1[0]);
        $lon1 = deg2rad($location1[1]);
        $lat2 = deg2rad($location2[0]);
        $lon2 = deg2rad($location2[1]);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
    
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
            'team_id',
            'location',
            'foto1',
            'foto2',
            'foto3',
            'address',
            'foto4',
            'surveyor_id'
    ];
    protected $appends = [
        'location',
    ];

    /**
     * ADD THE FOLLOWING METHODS TO YOUR Survey MODEL
     *
     * The 'lat' and 'lng' attributes should exist as fields in your table schema,
     * holding standard decimal latitude and longitude coordinates.
     *
     * The 'location' attribute should NOT exist in your table schema, rather it is a computed attribute,
     * which you will use as the field name for your Filament Google Maps form fields and table columns.
     *
     * You may of course strip all comments, if you don't feel verbose.
     */

    /**
    * Returns the 'lat' and 'lng' attributes as the computed 'location' attribute,
    * as a standard Google Maps style Point array with 'lat' and 'lng' attributes.
    *
    * Used by the Filament Google Maps package.
    *
    * Requires the 'location' attribute be included in this model's $fillable array.
    *
    * @return array
    */

    public function getLocationAttribute(): array
    {
        return [
            "lat" => (float)$this->lat,
            "lng" => (float)$this->lng,
        ];
    }

    /**
    * Takes a Google style Point array of 'lat' and 'lng' values and assigns them to the
    * 'lat' and 'lng' attributes on this model.
    *
    * Used by the Filament Google Maps package.
    *
    * Requires the 'location' attribute be included in this model's $fillable array.
    *
    * @param ?array $location
    * @return void
    */
    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lng'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    /**
     * Get the lat and lng attribute/field names used on this table
     *
     * Used by the Filament Google Maps package.
     *
     * @return string[]
     */
    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'lat',
            'lng' => 'lng',
        ];
    }

   /**
    * Get the name of the computed location attribute
    *
    * Used by the Filament Google Maps package.
    *
    * @return string
    */
    public static function getComputedLocation(): string
    {
        return 'location';
    }
    
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
    public function Team()
    {
        return $this->belongsTo(related:Team::class);
    }

    public function Surveyor()
    {
        return $this->belongsToMany(related:Surveyor::class)->withPivot('survey_surveyor');
    }
}
