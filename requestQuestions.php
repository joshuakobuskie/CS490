<?php

//Request questions from database
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
  //Requests Questions from database either by topic, difficulty, or all
  //Takes POST Parameters: (Difficulty), (Topic)
  //All parameters are (optional), a request with no parameters will return all questions by default
  //Do NOT inlcude the parenthesis in the key, it is only to symbolize optional parameters
  //Blank values will be returned for unfilled fields, not NULL

  //OLD VERSION
  //Select by Difficulty
  //if (!empty($_POST["Difficulty"])){
  //	$sql = "SELECT * FROM `questions` WHERE `Difficulty` = '".$_POST["Difficulty"]."';";
  //}
  //Select by Topic
  //elseif (!empty($_POST["Topic"])){
  //	$sql = "SELECT * FROM `questions` WHERE `Topic` = '".$_POST["Topic"]."';";
  //}
  //Select All
  //else{
  //	$sql = "SELECT * FROM `questions`;";
  //}

  //New Sorting Version
  //Base form
  $sql = "SELECT * FROM `questions`";
  //Check if ANY filter exists
  if(!empty($_POST["Topic"]) || !empty($_POST["Difficulty"]) || !empty($_POST["Keyword"])){
	$sql = $sql." WHERE ";
	$addAnd = false;
	
	//Contains Topic Filter
	if(!empty($_POST["Topic"])){
		if($addAnd){
			$sql = $sql." AND ";
		}
		$sql = $sql."`Topic` = '".$_POST["Topic"]."'";
		$addAnd = true;
	}
	
	//Contains Difficulty Filter
	if(!empty($_POST["Difficulty"])){
		if($addAnd){
			$sql = $sql." AND ";
		}
		$sql = $sql."`Difficulty` = '".$_POST["Difficulty"]."'";
		$addAnd = true;
	}
	
	//Contains Keyword Search
	if(!empty($_POST["Keyword"])){
		if($addAnd){
			$sql = $sql." AND ";
		}
		//Check name, parameters, and return value descriptions
		$sql = $sql."(`Name` LIKE '%".$_POST["Keyword"]."%' OR `Parameters` LIKE '%".$_POST["Keyword"]."%' OR `ReturnValue` LIKE '%".$_POST["Keyword"]."%')";
		$addAnd = true;
	}

  }
  
  $sql = $sql.";";
  
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Move questions into 2d array for json encode
      while($row = $result->fetch_assoc()) {
	  $data[] = $row;
	    }
    }
    //Initially, there was an else clause here in case of a bad query. However, this causes a blank query to return bad.
    //If no question exists in that field, the query has no failed, it simply has not returned anything
    echo json_encode($data, JSON_FORCE_OBJECT);
    $conn->close();
?>
