<?php
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
  //Inserts points and comments into database
  //Takes POST Parameters: ID, EID, QID, NamePoints, Case1Points, Case2Points, (Case3Points), (Case4Points), (Case5Points), (Comments)
  
  $sql = "UPDATE `exam_status` SET `State`= 'Released' WHERE `EID` = ".$_POST["EID"].";";
  $result = $conn->query($sql);
  
  if ($result){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Failed!");
  }
  $conn->close();
?>
