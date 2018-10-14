<?php

require_once dirname(__FILE__).'/TestConfig.php';


class PolicyManagerTest extends TestConfig {
    protected static $policyManager;

    public static function setUpBeforeClass() {
        $client = new AcrosureClient([
            "token" => TEST_SECRET_TOKEN,
            "endpointBase" => TEST_API_URL
        ]);
        self::$policyManager = $client->getPolicyManager();
    }

    public function testListPolicies() {
        $resp = self::$policyManager->getList(json_decode('{}'));
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(sizeof($resp->data) > 0);
        return $resp->data;
    }

    /**
     * @depends testListPolicies
     */
    public function testGetPolicyDetail($policies) {
        $policyId = $policies[0]->id;
        $resp = self::$policyManager->get($policyId);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue($resp->data->id == $policyId);
    }
}
?>