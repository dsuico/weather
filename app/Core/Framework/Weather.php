<?php

namespace App\Core\Framework;



abstract class Weather {

  protected $api;
  protected $apiKey;
  public $data, $request, $errors;
  
  abstract protected function init($data);
  abstract protected function prepareQueryParams($data);
  abstract protected function handleClientError(\GuzzleHttp\Exception\ClientException $ce);
  
  public function request($method = 'GET')
  {
    $response = false;

    try {

      if($method === 'GET')
        $this->buildQueryParams();

      $clientRes  = app('guzzleClient')->request($method, $this->api);
      $response   = json_decode($clientRes->getBody());

      if(isset($response->success) && !$response->success) {
        if(isset($response->error))
          $this->setErrors($response->error);
      } else {
        $this->setData($response);
      }

    } catch (\GuzzleHttp\Exception\ClientException $ce) {

      $this->handleClientError($ce);

    } catch (\Exception $e) {

      throw new \Exception("Internal Error Exception \n". $e->getMessage());

    }

    return $this;
  }

  protected function buildQueryParams()
  {
    if(!isset($this->request))
      return false;

    $params = http_build_query($this->request);

    $this->api .= strpos('?', $this->api) ? $params : "?{$params}";
  }


}