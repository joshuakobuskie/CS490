<?php 
   session_start();
   require( __DIR__ . "/functions.php");

    $data = array(
        'EID' => $_POST["EID"]
    );     
    print_r($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertRelease.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    if(isset($response)){
        $_SESSION["Response"] = "Successfully Released Results for Exam " . $_POST["EID"];
     }
     else{
        $_SESSION["Response"] = "Error Could Not Release Results for Exam " .  $_POST["EID"];
     }

    redirect("all_exams.php");
?>