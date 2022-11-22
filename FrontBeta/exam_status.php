<?php
   session_start();
   require( __DIR__ . "/functions.php");
   $data = array(
    'EID'=>3,
    'ID'=>2

 );     
 print_r($data);

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestStatus.php');
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $response = curl_exec($ch);
 curl_close($ch);

 $response=json_decode($response);
 
?>