<?php
if (!extension_loaded("curl")) {
  die("Enable the cURL extension first");
}

$para1 = $_POST['ship'];
$para2 = $_POST['num'];

$url = "http://127.0.0.1:8080/ship_cost_api/$para1/$para2";

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

curl_close($curl);

if ($response === false) {
    die("Error: " . curl_error($curl));
}

$response_data = json_decode($response, true);

if ($response_data === null) {
    die("Error: Failed to decode JSON response");
}

echo json_encode($response_data);
?>