<?php
   if(isset($_POST["Submit"])){
      $data = array(
         'ID' => $_POST["ID"],
         'Password' => md5($_POST["Password"])
      );     
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middle.php');
      //POST login data to middle
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //GET validation from middle
      $response = curl_exec($ch);
      curl_close($ch);

      $response=json_decode($response);
     
      if ($response[0] == "true"){
        echo "<h2> Hello, " . $data["ID"] . ". Welcome to the ". $response[1] ." page!";
      }
      else{
        echo '<h2>Welcome!</h2>
            ERROR: Bad Credentials
            <form method="post" action="login_data.php">
                <label for="ID">Username:</label><br>
                <input type="text" value="" name="ID"><br>
                <label for="Password">Password:</label><br>
                <input type="password" value="" name="Password"><br><br>
                <input type="submit" name="Submit" value="Submit">
            </form>'; 
      }
    
    }
   
?>
