<?php
// require_once '../lib/Acrosure.php';
require_once dirname(__FILE__).'/vendor/autoload.php';

$acrosureClient = new AcrosureClient([
    "token" => $_ENV["TEST_SECRET_TOKEN"],
    "endpointBase" => $_ENV["TEST_API_URL"] // as optional
]);

$applicationId = '';
$NEWLINE = "<br/>";
$APP_DATA = json_decode(file_get_contents("data.json"), false);
echo $NEWLINE;
echo '-------------------------------'.$NEWLINE;
echo 'start'.$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$resp = $acrosureClient->getApplicationManager()->create([ 
    "product_id" => $APP_DATA->product_id,
    "basic_data" => $APP_DATA->basic_data
]);

echo $NEWLINE;
echo 'create: '.json_encode($resp, JSON_PRETTY_PRINT).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$applicationId = $resp->data->id;
$resp = $acrosureClient->getApplicationManager()->getPackages($applicationId);
echo $NEWLINE;
echo 'get-packages: '.json_encode($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$packageCode = $resp->data[0]->package_code;
$resp = $acrosureClient->getApplicationManager()->selectPackage([
    "application_id" => $applicationId,
    "package_code" => $packageCode
]);
echo $NEWLINE;
echo 'select-package: '.json_encode($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$resp = $acrosureClient->getApplicationManager()->update([
    "application_id" => $applicationId,
    "basic_data" => $APP_DATA->basic_data,
    "package_options" => $APP_DATA->package_options,
    "additional_data" => $APP_DATA->additional_data
]);
echo $NEWLINE;
echo 'update: '.json_encode($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$resp = $acrosureClient->getApplicationManager()->confirm($applicationId);
echo $NEWLINE;
echo 'confirm:', json_encode($resp).$NEWLINE;
echo '==============================='.$NEWLINE;
echo json_encode($resp).$NEWLINE;
echo 'DONE'.$NEWLINE;
?>
