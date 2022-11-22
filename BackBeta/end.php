<?php
//Accept "ID", "Password"
//Query jsk47 user_accounts
//Pass Json back with echo
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

  $sql = 'SELECT `Role`, `ID` FROM `user_data` WHERE `Username` = "'.$_POST["ID"].'" AND
  `Password` = "'.$_POST["Password"].'"';
  
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data
      while($row = $result->fetch_assoc()) {
      	  $data[] = "true";
	  $data[] = $row["Role"];
	  $data[] = $row["ID"];
	    }
    } else {
      $data[] = "false";
      $data[] = "Invalid Credentials!";
    }
    echo json_encode($data);
    $conn->close();
?>
