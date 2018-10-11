<?php

class DataManager {
  const basePath = "data";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
  }
  public function get($data) {
      return $this->callAPI("get", $data);
  }
}

?>