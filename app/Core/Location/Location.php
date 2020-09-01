<?php

namespace App\Core\Location;

use App\Traits\TemperatureTrait;

class Location {

  use TemperatureTrait;
  
  public $model;

  public function __construct(LocationModel $model)
  {
    $this->model = $model;
  }

  public function get($filters = [], $load = [])
  {
    if(\Cache::has('hasNewLocation')) {
      $locations = $this->model->where($filters)->get()->load($load);
      $this->setLocationCache($locations);
      \Cache::forget('hasNewLocation');
    } else {
      $locations = \Cache::has('locations') ? 
        \Cache::get('locations') : $this->model->where($filters)->get()->load($load);
      if($locations->count())
      $this->setLocationCache($locations);
    }

    return $locations;
  }

  public function setLocationCache($locations)
  {
    \Cache::forget('locations');
    \Cache::add('locations', $locations);
  }

  public function store($data, $sources)
  {
    $this->model->city    = $data['city'];
    $this->model->country = $data['country'];
    
    $this->model->save();
    $this->model->temperature()->create([
      'temp' => $this->calculateTemperature($sources)

    ]);

    return $this->model->load('temperature');
  }
}