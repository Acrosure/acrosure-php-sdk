<?php

require_once dirname(__FILE__).'/../resource/APIResource.php';

class PolicyManager {
  const basePath = "policies";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
  }
  public function get($policyId) {
      return $this->callAPI("get", (object) ["policy_id" => $policyId]);
  }
  public function getList($data) {
      return $this->callAPI("list", $data);
  }
}

?>