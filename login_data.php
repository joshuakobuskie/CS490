<?php
   session_start();
   require(__DIR__ . "/functions.php");
   
   if( isset($_POST["ID"]) && isset($_POST["Password"]) ){
      $data = array(
         'ID' => $_POST["ID"],
         'Password' => md5($_POST["Password"])
      );     
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middle.php');
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);

      $response=json_decode($response);
      
      if ($response[0] == "true"){
        
        $_SESSION["Logged_In"] = $response[0];
        $_SESSION["Role"] = $response[1];
        $_SESSION["ID"] = $response[2];
        $_SESSION["Username"] = $data["ID"];

        if($_SESSION["Role"] == "Teacher"){
          redirect("teacher.php");
         
        }
        elseif($_SESSION["Role"] == "Student"){
          redirect("student.php");
        }
 
      }
      else{
        $_SESSION["Error"] = "Invalid Credentials!"; 
        redirect("index.php");
        
      }
    
    }
?>
