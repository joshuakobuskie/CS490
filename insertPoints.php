<?php

//Insert points and comments to database
//Echo Success if true
$servername = "sql1.njit.edu";
$username = "jsk47";
$password = "NJITHonors2022!";
$dbname = "jsk47";
$data = [];

//Process Optional paramters/Null Values
$params = array("Case3Result","Case3Possible", "Case3Points", "Case4Result", "Case4Possible", "Case4Points", "Case5Result", "Case5Possible", "Case5Points", "QConstraintResult", "QConstraintPossible", "QConstraintPoints", "Comments");
foreach($params as $option){
	if(empty($_POST[$option]) && !is_numeric($_POST[$option])){
		$_POST[$option] = "NULL";
	}
}

//$_POST["Case1Possible"] = $_GET["TEST"];

//Fix Possible points for a 3 test case situation
if(abs(($_POST["Case1Possible"] - floor($_POST["Case1Possible"])) - 0.333) < 0.001){
	$_POST["Case1Possible"] = $_POST["Case1Possible"] + 0.01;
}
else if(abs(($_POST["Case1Possible"] - floor($_POST["Case1Possible"])) - 0.666) < 0.001){
	$_POST["Case1Possible"] = $_POST["Case1Possible"] - 0.01;	
}

//Fix points scored for a 3 test case situation
if(abs(($_POST["Case1Points"] - floor($_POST["Case1Points"])) - 0.333) < 0.001){
        $_POST["Case1Points"] = $_POST["Case1Points"] + 0.01;
}
else if(abs(($_POST["Case1Points"] - floor($_POST["Case1Points"])) - 0.666) < 0.001){
	$_POST["Case1Points"] = $_POST["Case1Points"] - 0.01;
}

//Special cases where the student program execution failed and was accidentally nulled out for an optinoal test case
foreach(range(3,5) as $spIndex){
	if($_POST["Case".$spIndex."Possible"] != "NULL" && $_POST["Case".$spIndex."Result"] == "NULL"){
		$_POST["Case".$spIndex."Result"] = "";
	}
}

//echo $_POST["Case1Possible"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }
  //Inserts points and comments into database
  //Takes POST Parameters: ID, EID, QID, NamePoints, Case1Points, Case2Points, (Case3Points), (Case4Points), (Case5Points), (Comments)
  $sql = "UPDATE `jsk47`.`student_results` SET `NameResult` = '".$_POST["NameResult"]."', `NamePossible` = ".$_POST["NamePossible"].", `NamePoints`= ".$_POST["NamePoints"].", `Case1Result` = '".$_POST["Case1Result"]."', `Case1Possible` =
  ".$_POST["Case1Possible"].", `Case1Points` = ".$_POST["Case1Points"].", `Case2Result` = '".$_POST["Case2Result"]."', `Case2Possible` = ".$_POST["Case2Possible"].", `Case2Points` = ".$_POST["Case2Points"].", `Case3Result` =
  NULLIF('".$_POST["Case3Result"]."', 'NULL'), `Case3Possible` = ".$_POST["Case3Possible"].", `Case3Points` = ".$_POST["Case3Points"].", `Case4Result` = NULLIF('".$_POST["Case4Result"]."', 'NULL'), `Case4Possible` =
  ".$_POST["Case4Possible"].", `Case4Points` = ".$_POST["Case4Points"].", `Case5Result` = NULLIF('".$_POST["Case5Result"]."', 'NULL'), `Case5Possible` = ".$_POST["Case5Possible"].", `Case5Points` = ".$_POST["Case5Points"].",
  `QConstraintResult` = NULLIF('".$_POST["QConstraintResult"]."', 'NULL'), `QConstraintPossible` = ".$_POST["QConstraintPossible"].", `QConstraintPoints` = ".$_POST["QConstraintPoints"].", `Comments` =
  NULLIF('".$_POST["Comments"]."', 'NULL') WHERE `ID` = ".$_POST["ID"]." AND `EID` = ".$_POST["EID"]." AND `QID` = ".$_POST["QID"].";";

	//echo $sql;

  $result1 = $conn->query($sql);
  
  $sql = "UPDATE `exam_status` SET `State`= 'Graded' WHERE `EID` = ".$_POST["EID"]." AND `ID` = ".$_POST["ID"].";";
  
  $result2 = $conn->query($sql);
  
  if ($result1 && $result2){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Failed!");
  }
  $conn->close();
  
?>
