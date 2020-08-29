<?php

namespace App\Core\API;

use GuzzleHttp\Exception\ClientException;
use App\Core\Framework\Weather;
use App\Core\Framework\Interfaces\WeatherInterface;
class WeatherStack extends Weather implements WeatherInterface
{
  protected static $url         = 'http://api.weatherstack.com/current';
  protected static $access_key  = '0bf50a468f974928d0c2f0d9d52206f0';

  public $errors;

  public function init($data)
  {
    $this->api      = self::$url;
    $this->apiKey   = self::$access_key;
    $this->request  = $this->prepareQueryParams($data);

    return $this;
  }

  public function prepareQueryParams($location = [])
  {
    if(empty($location) || !isset($this->api))
      return null;

    $params['access_key'] = self::$access_key;
    $params['query']      = $location['city'] . ', ' . $location['country'];

    return $params;
  }

  public function handleClientError(ClientException $ce)
  {
    if ($ce->hasResponse()) {
      $response = $ce->getResponse();
      $this->errors = json_decode($response->getBody());
    }
    return $this;
  }

  public function setData($data)
  {
      $this->data['temperature'] = $data->current->temperature;
  }

  public function getData()
  {
      return $this->data;
  }

  public function getErrors()
  {
    return $this->errors;
  }

  public function setErrors($errors)
  {
    $this->errors['code'] = $errors->code;
    $this->errors['message'] = $errors->info;
  }
}
