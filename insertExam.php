<?php

//Insert new exam to database
//Echo Success if true
$servername = "sql1.njit.edu";
$username = "jsk47";
$password = "NJITHonors2022!";
$dbname = "jsk47";
$data = [];

//Process Optional paramters/Null Values
$params = array("QID1", "Points1", "QID2", "Points2", "QID3", "Points3", "QID4", "Points4", "QID5", "Points5", "QID6", "Points6", "QID7", "Points7", "QID8", "Points8", "QID9", "Points9", "QID10", "Points10");
foreach($params as $option){
	if(empty($_POST[$option]) && !is_numeric($_POST[$option])){
		$_POST[$option] = "NULL";
	}
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }
  //Inserts New Exam with QIDS into database
  //Takes POST Parameters: (QID1), (Points1), (QID2), (Points2), ..., (QID10), (Points10)
  //All parameters are (optional), meaning a blank exam can be created without adding questions, or a full exam can be created with all questions
  //The ability to modify exam,s by adding or removing questions can be incorporated at a later time
  //Do NOT inlcude the parenthesis in the key, it is only to symbolize optional parameters
  $sql = "INSERT INTO `jsk47`.`exams` (`QID1`, `Points1`, `QID2`, `Points2`, `QID3`, `Points3`, `QID4`, `Points4`, `QID5`, `Points5`, `QID6`, `Points6`, `QID7`, `Points7`, `QID8`, `Points8`, `QID9`, `Points9`, `QID10`, `Points10`) VALUES
  (".$_POST["QID1"].", ".$_POST["Points1"].", ".$_POST["QID2"].", ".$_POST["Points2"].", ".$_POST["QID3"].", ".$_POST["Points3"].", ".$_POST["QID4"].", ".$_POST["Points4"].", ".$_POST["QID5"].", ".$_POST["Points5"].", ".$_POST["QID6"].",
  ".$_POST["Points6"].", ".$_POST["QID7"].", ".$_POST["Points7"].", ".$_POST["QID8"].", ".$_POST["Points8"].", ".$_POST["QID9"].", ".$_POST["Points9"].", ".$_POST["QID10"].", ".$_POST["Points10"].");";
  
  $result = $conn->query($sql);
  
  if ($result){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Failed!");
  }

  //Creating student fields
  //NEED ID, EID, QID
  //Already have all QIDS in $params
  //Provide new EID
  $sql = "SELECT `EID` FROM `exams` ORDER BY `EID` DESC LIMIT 1;";
  $examID = $conn->query($sql);
  $EID = $examID->fetch_assoc();

  //Provide IDs for all students
  $sql = "SELECT `ID` FROM `user_data` WHERE `Role` = 'Student'";
  $studentIDS = $conn->query($sql);
  while($studentid = $studentIDS->fetch_assoc()){
    $SIDarray[] = $studentid["ID"];
  }
  $questions = array("QID1", "QID2", "QID3", "QID4", "QID5", "QID6", "QID7", "QID8", "QID9", "QID10");
  foreach($questions as $QID){
    if($_POST[$QID] != "NULL"){
      foreach($SIDarray as $SID){
	//Create Blank answer fields for all students for this exam
	$sql = "INSERT INTO `jsk47`.`student_results` (`ID`, `EID`, `QID`) VALUES ('".$SID."', '".$EID["EID"]."', '".$_POST[$QID]."');";
	$result = $conn->query($sql);
	if (!$result){
          echo json_encode("Student Generation Failed!");
	}
      }
    }
  }

  foreach($SIDarray as $SID){
    $sql = "INSERT INTO `exam_status` (`EID`, `ID`, `State`) VALUES ('".$EID["EID"]."', '".$SID."', 'Incomplete');";
    $result = $conn->query($sql);
    if (!$result){
	echo json_encode("Exam State Failed!");
    }
  }

  $conn->close();
?>
