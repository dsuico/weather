<?php

namespace App\Core\Temperature;

use Illuminate\Database\Eloquent\Model;

class TemperatureModel extends Model
{
    protected $table = 'temperatures';

    protected $fillable = [
        'temp'
    ];
}
