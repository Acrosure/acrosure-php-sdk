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
    public function create($data) {
        return $this->callAPI("create", $data);
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
