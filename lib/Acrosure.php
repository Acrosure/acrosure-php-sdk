<?php

// namespace Acrosure;

class APIResource {
    private $baseURL;
    private $token;

    public function __construct($baseURL, $token) {
        $this->baseURL = $baseURL;
        $this->token = $token;
    }
    public function callAPI($path, $data) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->baseURL."/".$path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $this->token",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw $err;
        } else {
            $result = json_decode($response);
            $json_string = json_encode($data, JSON_PRETTY_PRINT);
            var_dump($json_string);
            return $result;
        }
    }
}

class ResourceManager {
}

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
    public function get($data) {
        return $this->callAPI("get", $data);
    }
    public function create($data) {
        return $this->callAPI("create", $data);
    }
    public function update($data) {
        return $this->callAPI("update", $data);
    }
    public function getPackages($data) {
        return $this->callAPI("get-packages", $data);
    }
    public function getPackage($data) {
        return $this->callAPI("get-package", $data);
    }
    public function selectPackage($data) {
        return $this->callAPI("select-package", $data);
    }
    public function submit($data) {
        return $this->callAPI("submit", $data);
    }
    public function confirm($data) {
        return $this->callAPI("confirm", $data);
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
    public function get($data) {
        return $this->callAPI("get", $data);
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
        return $this->callAPI("get-info", $data);
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

}


?>
