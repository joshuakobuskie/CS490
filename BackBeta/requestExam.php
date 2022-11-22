<?php

//Request Exam questions from database
//Echo 
$servername = "sql1.njit.edu";
$username = "jsk47";
$password = "NJITHonors2022!";
$dbname = "jsk47";
$data = [];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$params = array("QID1" => "Points1", "QID2" => "Points2", "QID3" => "Points3", "QID4" => "Points4", "QID5" => "Points5", "QID6" => "Points6", "QID7" => "Points7", "QID8" => "Points8", "QID9" => "Points9", "QID10" => "Points10");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  //Returns Question details for all Questions in Exam X in the form of a JSON Object
  //Takes POST Parameters: (EID)
  //Three options for query, no EID, one EID, or all EIDS
  //If no EID is provided, return the data for the most recent exam
  //If an EID is provided, return the data for that exam
  //If EID = -1, return all exam data
 
  //
  $sql = "SELECT * FROM `exams`;";

  //Blank case, default to last
  if(!isset($_POST["EID"])){
	$sql = "SELECT `EID` FROM `exams` ORDER BY `EID` DESC LIMIT 1;";
	$examID = $conn->query($sql);
	$EID = $examID->fetch_assoc();
	$EID = $EID["EID"];
        $sql = "SELECT * FROM `exams` WHERE `EID` = '".$EID."';";
  }
  else if($_POST["EID"] != -1){
        $sql = "SELECT * FROM `exams` WHERE `EID` = '".$_POST["EID"]."';";
  }

  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    //Selected Exam by ID #, returned Questions and points
    //Get question data for each question
      while($row = $result->fetch_assoc()) {
	  $data[] = $row;
	  //$x is key, $xVal is value
	  foreach($row as $x => $xVal){
	  	//For all QID
		if(strpos($x, "QID") !== false && !is_null($xVal)){
			$sql = "SELECT * FROM `questions` WHERE `QID` = '".$xVal."';";
			$qData = $conn->query($sql);
			if($qData->num_rows > 0){
				while($qRow = $qData->fetch_assoc()){
					//Append Points for each question for easy display purposes
					foreach($params as $key => $value){
						if ($data["0"][$key] == $qRow["QID"]){
							$qRow["Points"] = $data["0"][$value];
						}
					}
					//Add question data for each question on exam for display
					$data[] = $qRow;
				}
			}
		}
	  }
	}
    }
    //Initially, there was an else clause here in case of a bad query. However, this causes a blank query to return bad.
    //If no question exists in that field, the query has not failed, it simply has not returned anything
    echo json_encode($data, JSON_FORCE_OBJECT);
    $conn->close();
?>
