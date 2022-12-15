<?php

//Request a student exam status from database
$servername = "sql1.njit.edu";
$username = "jsk47";
$password = "NJITHonors2022!";
$dbname = "jsk47";
$data = [];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  //Takes POST Parameters: ID, EID
  $sql = "SELECT `State` FROM `exam_status` WHERE `EID` = '".$_POST["EID"]."' AND `ID` = '".$_POST["ID"]."';"; 
  
  $result = $conn->query($sql);
 
  if ($result->num_rows > 0) {
      $status = $result->fetch_assoc();
      echo json_encode($status["State"]);
    }
    else {
      echo "Failed!";
    }
    //Since all current exams have values associated with them, this should never fail unless there is a server error

    $conn->close();
?>
