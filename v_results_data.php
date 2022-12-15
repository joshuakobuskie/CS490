<?php
   session_start();
   require( __DIR__ . "/functions.php");
   
   if($_SESSION["Role"] == "Teacher"){
    $data = array(
        'EID' =>  $_SESSION["EID"],
    );
    }
    else if($_SESSION["Role"] == "Student"){ 
        $_SESSION["EID"] = $_POST["EID"];
        $data = array(
            'EID' =>  $_SESSION["EID"],
        ); 
       
    }

   
    //echo $data["EID"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestExam.php');
    //POST newly created question data to middle
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //GET validation from middle
    $exam = curl_exec($ch);
    curl_close($ch);


    $exam=json_decode($exam);
    $_SESSION["exam"] = $exam;

    $i=1;
    foreach($exam as $q){
        
        $QID = $q->QID . $i;
        if($QID != ""){
                $data = array(
                    'EID' =>  $_SESSION["EID"],
                    'QID' => $q->QID
                );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestAnswers.php');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
    
    
            $response=json_decode($response);
            if($response != ""){
        
                foreach($response as $u){
                    if($u->QID != "" &&  ($u->ID == $_POST["ID"] || $u->ID == $_SESSION["ID"] ) && $u->EID == $_SESSION["EID"]){
                        $_SESSION["user_results" . $i] = $u;
                        $i++;
                    }
                }
                
            }
        }
    }

    //print_r($exam);
    redirect("view_results.php");

?>