<?php require(  __DIR__ . "/partials/nav.php"); ?>
<link rel="stylesheet" href="style.css">


<head>
  <h1>
    Welcome to the student page, <?php echo $_SESSION["Username"]; ?>
  </h1>

</head>

<body>

  <h2>
  <?php 
    
    if(isset($_SESSION["Response"])){ 
      echo $_SESSION["Response"];
      $_SESSION["Response"] = ""; 
    }
    
  ?>
  </h2>

</body>
