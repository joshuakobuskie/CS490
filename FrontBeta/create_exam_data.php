<?php
   session_start();
   require( __DIR__ . "/functions.php");
   
      if(isset($_POST["QID1"]) && isset($_POST["Points1"]) ){
         $data["QID1"] = $_POST["QID1"];
         $data["Points1"] = $_POST["Points1"];
      
      }
      if(isset($_POST["QID2"]) && isset($_POST["Points2"]) ){
         $data["QID2"] = $_POST["QID2"];
         $data["Points2"] = $_POST["Points2"];
      }
      if(isset($_POST["QID3"]) && isset($_POST["Points3"]) ){
         $data["QID3"] = $_POST["QID3"];
         $data["Points3"] = $_POST["Points3"];
      }
      if(isset($_POST["QID4"]) && isset($_POST["Points4"]) ){
         $data["QID4"] = $_POST["QID4"];
         $data["Points4"] = $_POST["Points4"];
      }
      if(isset($_POST["QID5"]) && isset($_POST["Points5"]) ){
         $data["QID5"] = $_POST["QID5"];
         $data["Points5"] = $_POST["Points5"];
      }
      
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