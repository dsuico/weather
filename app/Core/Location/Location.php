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
    return $this->model->where($filters)->get()->load($load);
  }

  public function store($data, $apiResult)
  {
    $this->model->city    = $data['city'];
    $this->model->country = $data['country'];
    
    $this->model->save();
    $this->model->temperature()->create([
      'temp' => $this->calculateTemperature($apiResult)

    ]);

    return $this->model->load('temperature');
  }
}