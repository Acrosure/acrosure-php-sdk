<?php

include 'api-resource.php';

class ApplicationManager {
    const basePath = "applications";

    private $httpClient;

    public function __construct(APIResource $httpClient) {
        $this->httpClient = $httpClient;
    }
    private function callAPI($path, $data) {
        return $this->httpClient->callAPI(ApplicationManager::basePath."/".$path, $data);
    }
    public function getList($data) {
        return $this->callAPI("list", $data);
    }
    public function get($applicationId) {
        return $this->callAPI("get", (object) ["application_id" => $application_id]);
    }
    public function create($data) {
        return $this->callAPI("create", $data);
    }
    public function update($data) {
        return $this->callAPI("update", $data);
    }
    public function getPackages($applicationId) {
        return $this->callAPI("get-packages", (object) ["application_id" => $applicationId]);
    }
    public function getPackage($applicationId) {
        return $this->callAPI("get-package", (object) ["applicaton_id" => $applicatonId]);
    }
    public function selectPackage($data) {
        return $this->callAPI("select-package", $data);
    }
    public function submit($applicatonId) {
        return $this->callAPI("submit", (object) ["applicaton_id" => $applicationId]);
    }
    public function confirm($applicationId) {
        return $this->callAPI("confirm", (object) ["applicaton_id" => $applicationId]);
    }
    public function getHash($data) {
        return $this->callAPI("get-hash", $data);
    }
}

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
        return $this->callAPI("get", (object) ["product_id" => $productId]);
    }
    public function getList($data) {
        return $this->callAPI("list", $data);
    }
}

class TeamManager {
    const basePath = "teams";

    private $httpClient;

    public function __construct(APIResource $httpClient) {
        $this->httpClient = $httpClient;
    }
    private function callAPI($path, $data) {
        return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
    }
    public function getInfo($data) {
        return $this->callAPI("get-info", (object) []);
    }
}

class DataManager {
    const basePath = "data";

    private $httpClient;

    public function __construct(APIResource $httpClient) {
        $this->httpClient = $httpClient;
    }
    private function callAPI($path, $data) {
        return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
    }
    public function get($data) {
        return $this->callAPI("get", $data);
    }
}

class PolicyManager {
    const basePath = "policies";

    private $httpClient;

    public function __construct(APIResource $httpClient) {
        $this->httpClient = $httpClient;
    }
    private function callAPI($path, $data) {
        return $this->httpClient->callAPI(ProductManager::basePath."/".$path, $data);
    }
    public function get($policyId) {
        return $this->callAPI("get", (object) ["policy_id" => $policyId]);
    }
    public function getList($data) {
        return $this->callAPI("list", $data);
    }
}

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
