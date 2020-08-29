<?php

namespace App\Core\Framework\Interfaces;


interface WeatherInterface {

    public function setData($data);
    public function getData();
    public function setErrors($data);
    public function getErrors();
}