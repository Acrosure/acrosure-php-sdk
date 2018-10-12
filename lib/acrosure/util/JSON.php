<?php
function jsonRemoveUnicodeSequences($struct, $pretty = false) {
    $jsonStr = '';
    if ($pretty) {
        $jsonStr = json_encode($struct, JSON_PRETTY_PRINT);
    } else {
        $jsonStr = json_encode($struct);
    }
    return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", $jsonStr);
}
?>