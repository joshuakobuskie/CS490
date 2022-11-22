<?php 

require(  __DIR__ . "/partials/nav.php"); 
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestQuestions.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$response=json_decode($response);
$_SESSION["qBank"] = $response;

?>

<head>
  <h1>Create an Exam</h1>
  <h3>
  <?php 
    if(isset($_SESSION["Response"])){ 
      echo $_SESSION["Response"];
      $_SESSION["Response"] = ""; 
    }
  ?>
  </h3>

</head>

<body>
  <div class="row">
    <div class="column header_left">
      <h3>Question Bank</h3>
    </div>
    <div class="column header_right">
      <h3>Questions</h3>
    </div>
  </div>
  <div class="row">
    
    <div class="column left" id="qBank" >
      <?php foreach($_SESSION["qBank"] as $q): ?>
        <table id="qTable">
          <tr>
            <td class="qInfo">
              <b> Question: </b>
            </td>
            <td class="qInfo">
              <?php 
                echo "Write a function named ". $q->Name .
                " that takes the parameter(s) " . $q->Parameters . 
                " and that returns " . $q->ReturnValue; 
              ?>
            </td>
          </tr>
          <tr>
            <td class="qInfo">
              <b> Topic: </b>
            </td>
            <td class="qInfo" >
              <?php echo $q->Topic . "<br>"; ?>
            </td>
            <td class="addBtn" style="border-style:none;" >
              <button class="add_button" id="<?php echo $q->QID?>" value="<?php echo "Write a function named ". $q->Name .
                " that takes the parameter(s) " . $q->Parameters . 
                " and that returns " . $q->ReturnValue; ?>" 
                onclick="addQuestion(this)">Add</button>
            </td>
          </tr>
          <tr>
            <td class="qInfo">
              <b> Difficulty: </b>
            </td>
            <td class="qInfo" >
              <?php echo $q->Difficulty ; ?>
            </td>
          </tr> 
        </table>
        <br>
      <?php endforeach; ?>

    </div>
    
  
    <div class="column right">
      
      <form method="post" action="create_exam_data.php" id="exam_template"> 
        <!-- form is dynamically updated using javascript --> 
        <h2 id="exam_message" >Add Questions from the Question Bank</h2>
        <button id="Submit_Exam" type="submit" name="Submit" style="margin-top:25px;width:120px;height:30px;" hidden>Create Exam </button>
    
      </form>
     
    </div>
  
  </div>

</body>
  

<script>
  var i = 1;
  function addQuestion(add) {
    //question bank ID
    const QID = add.id;
    const qInfo = add.value;
    //console.log(addButton_ID);
    const exam = document.getElementById("exam_template");
    const submitButton = document.getElementById("Submit_Exam");
    const message = document.getElementById("exam_message");

    //total number of questions added to the exam
    var all_questions = document.getElementsByTagName("p");
    submitButton.hidden=false;
    if(all_questions.length < 5){
      //create question preview
      const question = document.createElement('p');
      question.innerHTML = `<b>` + qInfo + `<b>`;
      question.id = "question" + QID;

      //create question points form
      
      const points = document.createElement('Input');
      points.type="number";
      points.id = "points" + i;
      points.className="points";
      points.name= "Points" + i;
      points.required="true";
      points.min="0";
      points.step="0.01";
      points.style="width:60px;margin-right:10px"
      const pLabel = document.createElement('Label');
      pLabel.id = "pLabel" + i;
      pLabel.for= "points" + i;
      pLabel.innerHTML = `Points: `;

      const pointsLabel = document.createElement('label');
      pointsLabel.for="Points" + add;

      //remove question form
      const remove = document.createElement('Input');
      remove.type="button";
      remove.class="create_options";
      remove.value = "Remove";
      remove.style=" border-radius:25px;width:10%;background-color:antiquewhite;margin-left:2px;"
      remove.id = i + QID;
      remove.onclick = function() { removeQuestion(remove) };
      
      //Hidden QID form to post the Question ID
      const QID_form = document.createElement('Input');
      QID_form.hidden="True";
      QID_form.name="QID" + i;
      QID_form.id="QID" + QID;
      //console.log(QID);
      QID_form.value=QID;
     
      //increment QID (question number on exam)
      i++;
      //limit question amount to 5
      if(i > 5){
        i=5;
      }
      
      //insert forms
      exam.insertBefore(question, submitButton); 
      exam.insertBefore(QID_form, submitButton);
      exam.insertBefore(pLabel, submitButton);
      exam.insertBefore(points, submitButton);
      exam.insertBefore(remove, submitButton);
      
     
      exam.insertBefore(document.createElement("br"), submitButton);
     
      //disable add button to avoid duplicates
      add.disabled = "true";
    }
    else{
      //add message that max questions has been reached
      window.alert("maximum questions reached");
      console.log("max questions reached");
    }

    if(all_questions.length > 0){
      message.hidden=true;
    }
  }

  function removeQuestion(remove){

    const exam = document.getElementById("exam_template");
    //question bank ID
    const QID = remove.id.slice(1);
    //console.log(QID);
    //exam question number
    const EQID = remove.id.slice(0,1);
    //console.log(EQID);
    const addButton = document.getElementById(QID);
    const question = document.getElementById("question" + QID);
    
    const points = document.getElementById("points" + EQID);
    const pLabel = document.getElementById("pLabel" + EQID);
    const qID_form = document.getElementById("QID" + QID);
    //console.log(qID_form.id);
    //console.log(EQID);
    const submitButton = document.getElementById("Submit_Exam");
    const message = document.getElementById("exam_message");
    
    remove.remove();
    question.remove();
    pLabel.remove();
    points.remove();
    qID_form.remove();
    i-=1;
    
    
    //remove a question from the exam
    //console.log(addButton);
    addButton.disabled=false;

    //total number of questions added to the exam
    var all_questions = document.getElementsByTagName("p");
    if(all_questions.length == 0){
      submitButton.hidden=true;
      message.hidden=false;
    }
    else{
      message.hidden=true;
    }
  }
  
  document.getElementById("Submit_Exam").addEventListener('click', function(e) { 
    
    var total_points = 0;
    const exam = document.getElementById("exam_template");
    var points = exam.getElementsByClassName("points");
   
    for(var i=0; i<points.length; i++){
      var q_points = parseInt(points[i].value);
      total_points+= q_points;
    }

    if(total_points != 100){
      e.preventDefault();
      window.alert("Exam must be out of 100 points");
    }
  });
</script>