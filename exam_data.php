<?php require(  __DIR__ . "/partials/nav.php"); ?>

<?php 
$data = array(
    'EID' => $_POST["EID"],
    
   
 );     
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestExam.php');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$response=json_decode($response);

$_SESSION["EID"] = $_POST["EID"];
$_SESSION["exam"] = $response;

redirect("exam.php");
?>