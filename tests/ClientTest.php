<?php

require_once dirname(__FILE__).'/TestConfig.php';

class AcrosureClientTest extends TestConfig {

  public function testMethodExists() {
    $this->assertTrue(method_exists('AcrosureClient', 'getApplicationManager'));
    $this->assertTrue(method_exists('AcrosureClient', 'getDataManager'));
    $this->assertTrue(method_exists('AcrosureClient', 'getPolicyManager'));
    $this->assertTrue(method_exists('AcrosureClient', 'getProductManager'));
    $this->assertTrue(method_exists('AcrosureClient', 'getTeamManager'));
    $this->assertTrue(method_exists('AcrosureClient', 'verifySignature'));
  }

}
?>