<?php
   session_start();
   require( __DIR__ . "/functions.php");

    $_SESSION["EID"] = $_POST["EID"];
    $data = array(
        'EID' => $_SESSION["EID"],
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestExam.php');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $exam = curl_exec($ch);
    curl_close($ch);


    $exam=json_decode($exam);
    $_SESSION["exam"] = $exam;

    foreach($exam as $q){
        
        $QID = $q->QID . $i;
        if($QID != ""){
            $data = array(
                'EID' => $_SESSION["EID"],
                'QID' => $q->QID
            );
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestAnswers.php');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
    
            $response=json_decode($response);

        }
    }

    

    if($response != ""){
        $_SESSION["all_results"] = $response;
    }
    else{
        $_SESSION["all_results"] = "No students have taken the exam";
    }
    redirect("view_all_results.php");

?>