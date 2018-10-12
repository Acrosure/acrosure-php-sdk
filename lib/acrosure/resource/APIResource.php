<?php
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
            $result = json_decode($response, true);
            $json_string = json_encode($data, JSON_PRETTY_PRINT);
            var_dump($json_string);
            return $result;
        }
    }
}

?>