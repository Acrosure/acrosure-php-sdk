<?php

require_once dirname(__FILE__).'/../resource/APIResource.php';


class ProductManager {
  const basePath = "products";

  private $httpClient;

  public function __construct(APIResource $httpClient) {
      $this->httpClient = $httpClient;
  }
  private function callAPI($path, $data) {
      return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
  }
  public function get($productId) {
      return $this->callAPI("get", ["product_id" => $productId]);
  }
  public function getList($data = NULL) {
      if ($data == NULL) {
        $data = json_decode('{}');
      }
      return $this->callAPI("list", $data);
  }
}

?>