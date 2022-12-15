<?php
   session_start();
   require( __DIR__ . "/functions.php");
   
   if( isset($_POST["QName"]) ){
      $data = array(
         'Name' => $_POST["QName"],
         'Parameters' => $_POST["Params"],
         'ReturnValue' => $_POST["RetVal"],
         'Topic' => $_POST["Topic"],
         'Difficulty' => $_POST["Difficulty"],
         'Test1' => $_POST["TestCase1"],
         'Ans1' => $_POST["TestAns1"],
         'Test2' => $_POST["TestCase2"],
         'Ans2' => $_POST["TestAns2"],
         'Test3' => $_POST["TestCase3"],
         'Ans3' => $_POST["TestAns3"],
         'Test4' => $_POST["TestCase4"],
         'Ans4' => $_POST["TestAns4"],
         'Test5' => $_POST["TestCase5"],
         'Ans5' => $_POST["TestAns5"],
         'QConstraint' => $_POST["Constraint"]

      );     
   }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleInsertQuestion.php');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
 
      $response=json_decode($response);
    

      if(isset($response) && $response=="Success"){
         $_SESSION["Response"] = "Successfully added question to the bank";
      }
      else{
         $_SESSION["Response"] = "Error could not add the question to the bank";
      }

      //$_SESSION["Response"]=$response;

     
      redirect("add_question.php");

?>