<?php

require_once dirname(__FILE__).'/TestConfig.php';


class TeamManagerTest extends TestConfig {
    protected static $teamManager;

    public static function setUpBeforeClass() {
        $client = new AcrosureClient([
            "token" => TEST_SECRET_TOKEN,
            "endpointBase" => TEST_API_URL
        ]);
        self::$teamManager = $client->getTeamManager();
    }

    public function testGetTeamInfo() {
        $resp = self::$teamManager->getInfo(json_decode('{}'));
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(explode("_", $resp->data->id)[0] == "team");
    }
}
?>