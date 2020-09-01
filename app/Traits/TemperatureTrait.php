<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait TemperatureTrait {
  public function calculateTemperature(Collection $sources)
  {
    return $sources->sum('data.temperature') / $sources->count();
  }
}