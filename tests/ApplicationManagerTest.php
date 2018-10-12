<?php

require_once dirname(__FILE__).'/TestConfig.php';


class ApplicationManagerTest extends TestConfig {
    protected static $applicationManager;
    protected static $packages;
    protected static $applicationId;

    public static function setUpBeforeClass() {
        $client = new AcrosureClient([
            "token" => TEST_SECRET_TOKEN,
            "endpointBase" => TEST_API_URL
        ]);
        self::$applicationManager = $client->getApplicationManager();
    }

    public function testCreateApplicationWithEmptyData() {
        $SUBMIT_APP_DATA = json_decode(file_get_contents(dirname(__FILE__)."/constants/SubmitAppData.json"), false);
        // $CONFIRM_APP_DATA = json_decode(file_get_contents("ConfirmAppData.json"), false);
        $resp = self::$applicationManager->create([
            "product_id" => $SUBMIT_APP_DATA->product_id
        ]);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue($resp->data->status == "INITIAL");
        return $resp->data->id;
    }

    /**
     * @depends testCreateApplicationWithEmptyData
     */
    public function testGetApplication($applicationId) {
        $resp = self::$applicationManager->get($applicationId);
        $this->assertTrue($resp->status == "ok");
        $app = $resp->data;
        $this->assertTrue($app->id == $applicationId);
        return $applicationId;
    }

    /**
     * @depends testGetApplication
     */
    public function testUpdateApplicatonWithBasicData($applicationId) {
        $SUBMIT_APP_DATA = json_decode(file_get_contents(dirname(__FILE__)."/constants/SubmitAppData.json"), false);
        $resp = self::$applicationManager->update([
            "application_id" => $applicationId,
            "basic_data" => $SUBMIT_APP_DATA->basic_data
        ]);
        $this->assertTrue($resp->status == "ok");
        $updatedApp = $resp->data;
        $this->assertTrue($updatedApp->id == $applicationId);
        $this->assertTrue($updatedApp->status == "PACKAGE_REQUIRED");
        return $applicationId;
    }

    /**
     * @depends testUpdateApplicatonWithBasicData
     */
    public function testGetPackages($applicationId) {
        $resp = self::$applicationManager->getPackages($applicationId);
        $this->assertTrue($resp->status == "ok");
        $packages = $resp->data;
        $this->assertTrue(sizeof($packages) > 0);
        self::$packages = $packages;
        return $applicationId;
    }

     /**
     * @depends testGetPackages
     */
    public function testSelectPackage($applicationId) {
        $firstPackage = self::$packages[0];
        $resp = self::$applicationManager->selectPackage([
            "application_id" => $applicationId,
            "package_code" => $firstPackage->package_code
        ]);
        $this->assertTrue($resp->status == "ok");
        $updatedApp = $resp->data;
        $this->assertTrue($updatedApp->status == 'DATA_REQUIRED');
        self::$applicationId = $applicationId;
        return (object) [
            "firstPackage" => $firstPackage,
            "applicationId" => $applicationId
        ];
    }

    /**
     * @depends testSelectPackage
     */
    public function testCurrentPackage($o) {
        $resp = self::$applicationManager->getPackage($o->applicationId);
        $this->assertTrue($resp->status == "ok");
        $currentPackage = $resp->data;
        $this->assertTrue($currentPackage->package_code == $o->firstPackage->package_code);
    }

    /**
     * @depends testCurrentPackage
     */
    public function testUpdateApplicationWithCompletedData() {
        $SUBMIT_APP_DATA = json_decode(file_get_contents(dirname(__FILE__)."/constants/SubmitAppData.json"), false);
        $resp = self::$applicationManager->update([
            "application_id" => self::$applicationId,
            "basic_data" => $SUBMIT_APP_DATA->basic_data,
            "package_options" => $SUBMIT_APP_DATA->package_options,
            "additional_data" => $SUBMIT_APP_DATA->additional_data
        ]);
        $this->assertTrue($resp->status == "ok");
        $updatedApp = $resp->data;
        $this->assertTrue($updatedApp->id == self::$applicationId);
        $this->assertTrue($updatedApp->status == 'READY');
    }

    /**
     * @depends testUpdateApplicationWithCompletedData
     */
    public function testGet2C2PHashForm() {
        $resp = self::$applicationManager->getHash([
            "application_id" => self::$applicationId,
            "frontend_url" => 'https://acrosure.com'
        ]);
        $this->assertTrue($resp->status == "ok");
    }

    /**
     * @depends testGet2C2PHashForm
     */
    public function testSubmitApplication() {
        $resp = self::$applicationManager->submit(self::$applicationId);
        $this->assertTrue($resp->status == "ok");
        $submittedApp = $resp->data;
        $this->assertTrue($resp->data->status == "SUBMITTED");
    }
}
?>