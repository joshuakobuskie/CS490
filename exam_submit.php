<?php
   session_start();
   require( __DIR__ . "/functions.php");
    $i=1;
    for($i=1; $i<=5;$i++){

        $data['ID'] = $_SESSION["ID"];
        $data['EID'] = $_SESSION["EID"];
        if($_POST["QID" . $i]!="" && $_POST["Answer" . $i]!="" ){
            $data['QID'] = $_POST["QID" . $i];
            $data['Answer'] = $_POST["Answer" . $i];
        }
        //print_r($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertAnswer.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response=json_decode($response);
    }
     
    if(!empty($response) && $response=="Success"){
        $_SESSION["Response"] = "Successfully submitted exam!";
    }
    else{
        $_SESSION["Response"] = "Error: could not submit your exam";
    }
    //echo $response;
    //echo $_SESSION["Response"];
    redirect("student.php");


?>



