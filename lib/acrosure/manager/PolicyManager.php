<?php

require_once dirname(__FILE__).'/../resource/APIResource.php';

class PolicyManager {
  const basePath = "policies";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(PolicyManager::basePath."/".$path, $data);
  }
  public function get($policyId) {
      return $this->callAPI("get", ["policy_id" => $policyId]);
  }
  public function getList($data = NULL) {
      if ($data == NULL) {
        $data = json_decode('{}');
      }
      return $this->callAPI("list", $data);
  }
}

?>