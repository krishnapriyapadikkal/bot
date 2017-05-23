<?php

 $url = "https://api.telegram.org/bot391062433:AAE7lq0n8rIHBPKgqYiuzKELeRlmlBfcYd8/getUpdates";

$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_URL,$url);

$result=curl_exec($ch);

curl_close($ch);


var_dump(json_decode($result, true));
?>
