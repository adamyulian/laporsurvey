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
            'team_id',
            'location'
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
}
