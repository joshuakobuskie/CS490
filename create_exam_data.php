<?php
   session_start();
   require( __DIR__ . "/functions.php");
   
      $j = 1;
      for($i=1; $i<=5; $i++){
         //If null, rightshift
         if($_POST["QID" . $i] != "" || $_POST["Points" .  $i] != ""){
            $data["QID". $j] = $_POST["QID" . $i];
            $data["Points" . $j] = $_POST["Points" . $i];
            $j++;
         }
      }
      
     // print_r($data);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertExam.php');
      //POST newly created exam to middle
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //GET validation from middle
      $response = curl_exec($ch);
      curl_close($ch);
 
      $response=json_decode($response); 
    
      if(isset($response) && $response=="Success"){
         $_SESSION["Response"] = "Successfully created exam";
      }
      else{
         $_SESSION["Response"] = "Error could not create exam";
      }
   
   redirect("create_exam.php");

?>
