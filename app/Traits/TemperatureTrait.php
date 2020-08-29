<?php

namespace App\Traits;

trait TemperatureTrait {
  public function calculateTemperature($result)
  {
    $temp = 0;
    foreach($result as $api) {
      $temp += $api->data['temperature'];
    }

    return $temp / count($result);
  }
}