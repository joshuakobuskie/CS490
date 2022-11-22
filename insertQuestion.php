<?php

//Insert new question to database
//Echo Success if true
$servername = "sql1.njit.edu";
$username = "jsk47";
$password = "NJITHonors2022!";
$dbname = "jsk47";
$data = [];

//Process Optional paramters/Null Values
$params = array("Test3", "Ans3", "Test4", "Ans4", "Test5", "Ans5", "QConstraint");
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
  //Inserts New Question into database
  //Takes POST Parameters: Difficulty, Topic, Name, Parameters, ReturnValue, Test1, Ans1, Test2, Ans2, (Test3), (Ans3), (Test4), (Ans4), (Test5), (Ans5)
  //All parameters after Ans2 are (optional)
  //Do NOT inlcude the parenthesis in the key, it is only to symbolize optional parameters
  //NULLIF('".$_POST["Comments"]."', 'NULL') fixes NULL fields
  $sql = "INSERT INTO `jsk47`.`questions` (`Difficulty`, `Topic`, `Name`, `Parameters`, `ReturnValue`, `Test1`, `Ans1`, `Test2`, `Ans2`, `Test3`, `Ans3`, `Test4`, `Ans4`, `Test5`, `Ans5`, `QConstraint`) VALUES ('".$_POST["Difficulty"]."',
  '".$_POST["Topic"]."', '".$_POST["Name"]."', '".$_POST["Parameters"]."', '".$_POST["ReturnValue"]."', '".$_POST["Test1"]."', '".$_POST["Ans1"]."', '".$_POST["Test2"]."', '".$_POST["Ans2"]."', NULLIF('".$_POST["Test3"]."', 'NULL'),
  NULLIF('".$_POST["Ans3"]."', 'NULL'), NULLIF('".$_POST["Test4"]."','NULL'), NULLIF('".$_POST["Ans4"]."', 'NULL'), NULLIF('".$_POST["Test5"]."', 'NULL'), NULLIF('".$_POST["Ans5"]."', 'NULL'), NULLIF('".$_POST["QConstraint"]."', 'NULL'));";
  //echo $sql."<br>";
  $result = $conn->query($sql);
  
  if ($result){
  	echo json_encode("Success");
  }
  else{
	echo json_encode("Failed!");
  }
  $conn->close();
?>
