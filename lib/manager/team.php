<?php

class TeamManager {
  const basePath = "teams";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
  }
  public function getInfo($data) {
      return $this->callAPI("get-info", (object) []);
  }
}

?>