<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
           'nama',
           'register',
           'luas',
           'tahun_perolehan',
           'alamat',
           'penggunaan',
           'asal',
           'surveyor',
           'user_id',
            'lat',
            'lng', 
            'location_target',
        ];
    
        protected $appends = [
            'location_target',
        ];
    
        /**
         * ADD THE FOLLOWING METHODS TO YOUR Target MODEL
         *
         * The 'lat' and 'lng' attributes should exist as fields in your table schema,
         * holding standard decimal latitude and longitude coordinates.
         *
         * The 'location_target' attribute should NOT exist in your table schema, rather it is a computed attribute,
         * which you will use as the field name for your Filament Google Maps form fields and table columns.
         *
         * You may of course strip all comments, if you don't feel verbose.
         */
    
        /**
        * Returns the 'lat' and 'lng' attributes as the computed 'location_target' attribute,
        * as a standard Google Maps style Point array with 'lat' and 'lng' attributes.
        *
        * Used by the Filament Google Maps package.
        *
        * Requires the 'location_target' attribute be included in this model's $fillable array.
        *
        * @return array
        */
    
        public function getLocationTargetAttribute(): array
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
        * Requires the 'location_target' attribute be included in this model's $fillable array.
        *
        * @param ?array $location
        * @return void
        */
        public function setLocationTargetAttribute(?array $location): void
        {
            if (is_array($location))
            {
                $this->attributes['lat'] = $location['lat'];
                $this->attributes['lng'] = $location['lng'];
                unset($this->attributes['location_target']);
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
            return 'location_target';
        }
    public function Team()
    {
        return $this->belongsTo(related:Team::class);
    }
}
