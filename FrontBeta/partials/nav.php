<?php  
session_start(); 
require(  __DIR__ . "/../functions.php"); 
?>
<link rel="stylesheet" href="/../style.css">

<nav>

  <?php if($_SESSION["Role"] == "Teacher"): ?>
    <a href="teacher.php">Home</a>
    <a href="add_question.php">Add Question</a>
    <a href="create_exam.php">New Exam</a>
  <?php elseif($_SESSION["Role"] == "Student"): ?>
    <a href="student.php">Home</a>
  <?php endif; ?>

  <?php if($_SESSION["Logged_In"]=="true"): ?>
    <a href="all_exam_data.php">Assignments</a>
    <a id="logout" href="logout.php">Logout</a>
  
  <?php else:
    $_SESSION["Error"] = "You must be logged in to view this page";
    redirect("index.php");
    endif;
  ?>
 
</nav>

<script>
  
  document.getElementById("logout").addEventListener('click', function(e) { 
        var confirm = window.confirm("Are you sure you would like to logout?");
        if(!confirm){
            e.preventDefault();
        }
  }); 


</script>