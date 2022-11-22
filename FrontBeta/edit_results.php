<?php
    session_start();
    
    $i=1;
    //loop through all questions on exam
    for($i=1; $i<=5;$i++){
        
        //limits curl requests to the total amount of questions in exam
       
        if($_POST["QID" . $i] != ""){   
            $data["ID"] = $_POST["ID"];
            $data["EID"] = $_POST["EID"];
            $data["QID"] = $_POST["QID" . $i];
            
            $data["NameResult"] = $_POST["NameResult" . $i];
            $data["NamePossible"] = $_POST["NamePossible" . $i];
            $data["NamePoints"] = $_POST["NamePoints" . $i];
            
            $data["Case1Result"] = $_POST["Case1Result" . $i];
            $data["Case1Possible"] = $_POST["Case1Possible" . $i];
            $data["Case1Points"] = $_POST["Case1Points" . $i];
          
            $data["Case2Result"] = $_POST["Case2Result" . $i];
            $data["Case2Possible"] = $_POST["Case2Possible" . $i];
            $data["Case2Points"] = $_POST["Case2Points" . $i];      
            $data["Comments"] = $_POST["Comments" . $i];


            //non required fields, add when working
            
            /*$data['Case3Result'] = $_POST["Case3Result" . $i];
            $data['Case3Possible'] = $_POST["Case3Possible" . $i];
            $data['Case3Points'] = $_POST["Case3Points" . $i];   
            $data['Case4Result'] = $_POST["Case4Result" . $i];
            $data['Case4Possible'] = $_POST["Case4Possible" . $i];
            $data['Case4Points'] = $_POST["Case4Points" . $i];      
            $data['Case5Result'] = $_POST["Case5Result" . $i];
            $data['Case5Possible'] = $_POST["Case5Possible" . $i];
            $data['Case5Points'] = $_POST["Case5Points" . $i];*/
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertPoints.php');
            //POST answer data to middle
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //GET validation from middle
            $response = curl_exec($ch);
            curl_close($ch);


            $response=json_decode($response);
            
        }
    }

    $EID["EID"] = $_POST["EID"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertRelease.php');

    curl_setopt($ch, CURLOPT_POSTFIELDS, $EID);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);


   
    if(isset($response) && $response=="Success"){
        $_SESSION["Response"] = "Successfully edited the grade!";
    }
    else{
        $_SESSION["Response"] = "Error: could not edit grade";
    }
    
    require("v_results_data.php");

?>