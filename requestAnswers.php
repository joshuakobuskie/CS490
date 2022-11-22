<?php

//Request student answer for exams from database
//Echo 
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
  //Requests answers based on question and exam, returns for all students for that question
  //This is designed to allow for the grading of one question at a time for all students who took the exam
  //After grading answers, please call insertPoints.php for each student returned using the QID, EID, and ID provided
  //Takes POST Parameters: EID, QID

  //$sql = "SELECT * FROM `student_results` WHERE `EID` = '".$_POST["EID"]."' AND `QID` = '".$_POST["QID"]."';";
  $sql = "SELECT `student_results`.*, `user_data`.`Username` from `student_results`, `user_data` WHERE `student_results`.`ID` = `user_data`.`ID` AND `EID` = '".$_POST["EID"]."' AND `QID` = '".$_POST["QID"]."';";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Move answers into 2d array for json encode
      while($row = $result->fetch_assoc()) {
	  $data[] = $row;
	    }
    }
    else {
      echo "Failed!";
    }
    //Since all current exams have values associated with them, this should never fail unless there is a server error

    echo json_encode($data, JSON_FORCE_OBJECT);
    $conn->close();
?>
