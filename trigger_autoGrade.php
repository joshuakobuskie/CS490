<?php 
   session_start();
   require( __DIR__ . "/functions.php");

    $data = array(
        'EID' => $_POST["EID"]
    );     

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/autograderv2.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    //echo $response;
    if(isset($response)){
        $_SESSION["Response"] = "Successfully graded exam " . $_POST["EID"];
     }
     else{
        $_SESSION["Response"] = "Error could not grade exam " .  $_POST["EID"];
     }

    redirect("all_exams.php");
?>
