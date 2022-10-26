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

  //Select by Difficulty
  if (isset($_POST["Difficulty"])){
	$sql = "SELECT * FROM `questions` WHERE `Difficulty` = '".$_POST["Difficulty"]."';";
  }
  //Select by Topic
  elseif (isset($_POST["Topic"])){
	$sql = "SELECT * FROM `questions` WHERE `Topic` = '".$_POST["Topic"]."';";
  }
  //Select All
  else{
	$sql = "SELECT * FROM `questions`;";
  }
  
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
