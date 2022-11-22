<?php

//Request student's last submission for a question from database
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
  //Request student's last submission for a question from database
  //Takes POST Parameters: ID, EID, QID
  
  $sql = "SELECT * FROM `student_results` WHERE `ID` = '".$_POST["ID"]."' AND `EID` = '".$_POST["EID"]."' AND `QID` = '".$_POST["QID"]."';";
  
  $result = $conn->query($sql);
  
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
	    echo json_encode($row);
	    }
    }
    else{
	echo json_encode("Failed!");
    }

    $conn->close();
?>
