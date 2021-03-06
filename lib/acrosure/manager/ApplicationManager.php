<?php

require_once dirname(__FILE__).'/../resource/APIResource.php';

class ApplicationManager {
  const basePath = "applications";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(ApplicationManager::basePath."/".$path, $data);
  }
  public function getList($data = NULL) {
      if ($data == NULL) {
        $data = json_decode('{}');
      }
      return $this->callAPI("list", $data);
  }
  public function get($applicationId) {
      return $this->callAPI("get", ["application_id" => $applicationId]);
  }
  public function create($data) {
      return $this->callAPI("create", $data);
  }
  public function update($data) {
      return $this->callAPI("update", $data);
  }
  public function getPackages($applicationId) {
      return $this->callAPI("get-packages", ["application_id" => $applicationId]);
  }
  public function getPackage($applicationId) {
      return $this->callAPI("get-package", ["application_id" => $applicationId]);
  }
  public function selectPackage($data) {
      return $this->callAPI("select-package", $data);
  }
  public function submit($applicationId) {
      return $this->callAPI("submit", ["application_id" => $applicationId]);
  }
  public function confirm($applicationId) {
      return $this->callAPI("confirm", ["application_id" => $applicationId]);
  }
  public function getHash($data) {
      return $this->httpClient->callAPI("payments/2c2p/get-hash", $data);
  }
}

?>