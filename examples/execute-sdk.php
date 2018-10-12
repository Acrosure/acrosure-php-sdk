<?php
header('Content-Type: application/json;charset=utf-8');

require_once dirname(__FILE__).'/vendor/autoload.php';

$acrosureClient = new AcrosureClient([
    "token" => $_ENV["TEST_SECRET_TOKEN"],
    "endpointBase" => $_ENV["TEST_API_URL"] // as optional
]);

function jsonRemoveUnicodeSequences($struct) {
    return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct, JSON_PRETTY_PRINT));
}
 
$applicationId = '';
$NEWLINE = "\n";
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
echo '[create]'.$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$applicationId = $resp->data->id;
$resp = $acrosureClient->getApplicationManager()->getPackages($applicationId);
echo $NEWLINE;
echo '[get-packages]'.$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$packageCode = $resp->data[0]->package_code;
$resp = $acrosureClient->getApplicationManager()->selectPackage([
    "application_id" => $applicationId,
    "package_code" => $packageCode
]);
echo $NEWLINE;
echo '[select-package]'.$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$resp = $acrosureClient->getApplicationManager()->update([
    "application_id" => $applicationId,
    "basic_data" => $APP_DATA->basic_data,
    "package_options" => $APP_DATA->package_options,
    "additional_data" => $APP_DATA->additional_data
]);
echo $NEWLINE;
echo "[update]".$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '-------------------------------'.$NEWLINE;
$resp = $acrosureClient->getApplicationManager()->confirm($applicationId);
echo $NEWLINE;
echo '[confirm]'.$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '==============================='.$NEWLINE;
echo jsonRemoveUnicodeSequences($resp).$NEWLINE;
echo '=============== DONE ==================='.$NEWLINE;
?>
