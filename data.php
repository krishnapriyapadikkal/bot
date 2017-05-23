<?php


$url="https://api.telegram.org/bot391062433:AAE7lq0n8rIHBPKgqYiuzKELeRlmlBfcYd8/getUpdates";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURL_HEADER, false);
curl_setopt($ch, CURLOPT_TIMEOUT,5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('cotent-type:application/json'));

$result=curl_exec($ch);
curl_close($ch);

$curl_jason = var_dump(json_decode($result));
print_r($curl_jason);
echo $curl_jason


?>

