<?php

namespace App\Core\API;

use GuzzleHttp\Exception\ClientException;
use App\Core\Framework\Weather;
use App\Core\Framework\Interfaces\WeatherInterface;

class OpenWeatherMap extends Weather implements WeatherInterface
{
  protected static $url         = 'https://api.openweathermap.org/data/2.5/weather';
  protected static $access_key  = '1dca4cce1478b5bded9a8ea780f8d43a';

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
      return false;

    $params['appid']  = self::$access_key;
    $params['q']      = $location['city'] . ', ' . $location['country'];
    $params['units']  = 'metric'; //set to celsius

    return $params;
  }

  public function handleClientError(ClientException $ce)
  {
    if ($ce->hasResponse()) {
      $response = $ce->getResponse();
      $bodyResp = json_decode($response->getBody());
      
      $this->errors['code'] = $bodyResp->cod;
      $this->errors['message'] = $bodyResp->message;
    }
    
    return $this;
  }

  public function setData($data)
  {
      $this->data['temperature'] = $data->main->temp;
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
    $this->errors['code'] = $errors['code'];
    $this->errors['message'] = $errors['desc'];
  }
}
