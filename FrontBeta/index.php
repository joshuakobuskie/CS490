<?php session_start(); ?>

<link rel="stylesheet" href="style.css">

<div class="title">
  <br>
  <h2>Welcome! Please Login</h2>

  <?php if( isset($_SESSION["Error"]) ){
      echo $_SESSION["Error"] ;
      session_destroy();
  }
  ?>

</div>


<div class="center" >
  
  <br>
  <form method="post" action="login_data.php" autocomplete="off">
    <label for="ID">Username:</label><br>
    <input type="text" value="" name="ID"><br>
    <label for="Password">Password:</label><br>
    <input type="password" value="" name="Password" autocomplete="new-password"><br><br>
    <button type="submit" name="Submit" style="width:100px;display: block; margin: 0 auto;">Login </button>
  </form>
</div>
<?php session_reset(); ?>
