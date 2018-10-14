<?php

require_once dirname(__FILE__).'/TestConfig.php';


class DataManagerTest extends TestConfig {
    protected static $dataManager;

    public static function setUpBeforeClass() {
        $client = new AcrosureClient([
            "token" => TEST_SECRET_TOKEN,
            "endpointBase" => TEST_API_URL
        ]);
        self::$dataManager = $client->getDataManager();
    }

    public function testGetDataValuesWithNoDependencies() {
        $resp = self::$dataManager->get([
            "handler" => "province"
        ]);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(sizeof($resp->data) > 0);
    }

    /**
     * @depends testGetDataValuesWithNoDependencies
     */
    public function testGetDataValuesWithOneDependencies() {
        $resp = self::$dataManager->get([
            "handler" => "district",
            "dependencies" => ['กรุงเทพมหานคร']
        ]);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(sizeof($resp->data) > 0);
    }

    /**
     * @depends testGetDataValuesWithOneDependencies
     */
    public function testGetDataValuesWithTwoDependencies() {
        $resp = self::$dataManager->get([
            "handler" => "district",
            "dependencies" => ['กรุงเทพมหานคร', 'ห้วยขวาง']
        ]);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(sizeof($resp->data) > 0);
    }
}
?>