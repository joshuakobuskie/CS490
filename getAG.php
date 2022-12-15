<?php
$_POST["EID"] = 1;
$curl_request = curl_init();
curl_setopt($curl_request, CURLOPT_URL, "https://afsaccess4.njit.edu/~lg296/autograderv2.php");
curl_setopt($curl_request, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl_request);
curl_close($curl_request);
echo $response;
?>
