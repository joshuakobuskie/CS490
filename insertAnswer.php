<?php

//Insert student answer to database
//Echo Success if true
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
  //Inserts student answer into database
  //Takes POST Parameters: ID, EID, QID, Answer
  $sql = "UPDATE `student_results` SET `Answer`= '".$_POST["Answer"]."' WHERE `ID` = '".$_POST["ID"]."' AND `EID` = '".$_POST["EID"]."' AND `QID` = '".$_POST["QID"]."';";
  
  $result2 = $conn->query($sql);
  
  $sql = "UPDATE `exam_status` SET `State`= 'Submitted' WHERE `EID` = '".$_POST["EID"]."' AND `ID` = '".$_POST["ID"]."';";
  
  $result1 = $conn->query($sql);
  
  if ($result1 && $result2){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Failed!");
  }
  
  $conn->close();

/*
//OLD VERSION STORED BELOW
//MAY WANT TO CHANGE BACK AT SOME POINT IN FAVOR OF SUBMISSION BUTTON FORM

<?php

//Insert student answer to database
//Echo Success if true
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
  //Inserts student answer into database
  //Takes POST Parameters: ID, EID, QID, Answer
  $sql = "UPDATE `student_results` SET `Answer`= ".$_POST["Answer"]." WHERE `ID` = ".$_POST["ID"]." AND `EID` = ".$_POST["EID"]." AND `QID` = ".$_POST["QID"].";";
  
  $result = $conn->query($sql);
  
  if ($result){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Insert Failed!");
  }
  $conn->close();
?>
*/
?>
