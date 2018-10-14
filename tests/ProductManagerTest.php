<?php

require_once dirname(__FILE__).'/TestConfig.php';


class ProductManagerTest extends TestConfig {
    protected static $productManager;

    public static function setUpBeforeClass() {
        $client = new AcrosureClient([
            "token" => TEST_SECRET_TOKEN,
            "endpointBase" => TEST_API_URL
        ]);
        self::$productManager = $client->getProductManager();
    }

    public function testGetProductList() {
        $resp = self::$productManager->getList(json_decode('{}'));
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue(sizeof($resp->data) > 0);
        return $resp->data;
    }

    /**
     * @depends testGetProductList
     */
    public function testGetProductDetail($products) {
        $productId = $products[0]->id;
        $resp = self::$productManager->get($productId);
        $this->assertTrue($resp->status == "ok");
        $this->assertTrue($resp->data->id == $productId);
    }
}
?>