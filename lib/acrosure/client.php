<?php

require_once dirname(__FILE__).'/manager/resource/api.php';
require_once dirname(__FILE__).'/manager/application.php';
require_once dirname(__FILE__).'/manager/product.php';
require_once dirname(__FILE__).'/manager/team.php';
require_once dirname(__FILE__).'/manager/data.php';
require_once dirname(__FILE__).'/manager/policy.php';

class AcrosureClient {
  const DEFAULT_ENDPOINT_BASE = 'https://api.acrosure.com';

  private $endpointBase;
  private $token;

  private $applicationManager;
  private $policyManager;
  private $productManager;
  private $teamManager;
  private $dataManager;

  public function __construct(array $args) {
      $this->token = $args['token'];
      $this->endpointBase = AcrosureClient::DEFAULT_ENDPOINT_BASE;
      if (array_key_exists('endpointBase', $args) && !empty($args['endpointBase'])) {
          $this->endpointBase = $args['endpointBase'];
      }
      $httpClient = new APIResource($this->endpointBase, $this->token);
      $this->applicationManager = new ApplicationManager($httpClient);
      $this->productManager = new ProductManager($httpClient);
      $this->teamManager = new TeamManager($httpClient);
      $this->policyManager = new PolicyManager($httpClient);
      $this->dataManager = new DataManager($httpClient);
  }

  public function getApplicationManager() {
      return $this->applicationManager;
  }
  public function getPolicyManager() {
      return $this->policyManager;
  }
  public function getProductManager() {
      return $this->productManager;
  }
  public function getTeamManager() {
      return $this->getTeamManager;
  }
  public function getDataManager() {
      return $this->getDataManager;
  }

  public function verifySignature($signature, $rawData) {
      $expected = hash_hmac("sha256", json_encode($rawData), $this->token, true);
      return $signature == $expected;
  }
}

?>