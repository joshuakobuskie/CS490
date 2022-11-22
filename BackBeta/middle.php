<?php
//POST VERSION
$postData = array("ID" => $_POST["ID"], "Password" => $_POST["Password"]);

//TESTING VERSION
//$postData = array("ID" => "test", "Password" => "000000000000000000000000000000000000000000000000000000000000");

$curl_request = curl_init();
curl_setopt($curl_request, CURLOPT_URL, "https://afsaccess4.njit.edu/~jsk47/end.php");
curl_setopt($curl_request, CURLOPT_POSTFIELDS, $postData);
curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl_request);
curl_close($curl_request);

//echo json
echo $response;
?>
