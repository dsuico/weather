<?php

namespace App\Core\Location;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    protected $table ='locations';

    protected $fillable = [
        'city', 'country'
    ];

    public function temperature()
    {
        return $this->hasOne(\App\Core\Temperature\TemperatureModel::class, 'location_id', 'id');
    }
}
