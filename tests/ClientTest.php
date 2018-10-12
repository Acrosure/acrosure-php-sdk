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

  public function testVerifyWebhookSignature() {
    $client = new AcrosureClient([
      "token" => TEST_SECRET_TOKEN,
      "endpointBase" => TEST_API_URL
    ]);
    $isValid = $client->verifySignature(
      '1b0a6f0c0986671819cd19c38e201719b0531e72dfba312ca121190ea662a97b',
      json_decode('{"data":"อโครชัว!"}')
    );
    $this->assertTrue($isValid);
  }
}
?>