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
  
  <h1>Create a Question</h1>
  
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
    <div class="column left">
      <div id="question_form">
        <form method="post" action="question_data.php">

          Write a function named
          <input type="text" name="QName" ID="Qname" required>
          that takes the parameter(s)
          <input type="text" name="Params" ID="Params" required>
          and that returns
          <input type="text" name="RetVal" ID="RetVal" required>
        

          <br><br>
          
          <label for="Topic"> Topic: </label>
            <select name="Topic" id="Topic" required>
              <option value="For Loops">For Loops</option>
              <option value="While Loops">While Loops</option>
              <option value="Variables">Variables</option>
              <option value="Lists">Lists</option>
              <option value="Conditionals">Conditionals</option>
            </select> 

          <br><br>

          <label for="Difficulty"> Difficulty: </label>
            <select name="Difficulty" id="DifficultInty" required>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
          </select>

          <br><br>
          <label for="TestCase"  > Test Case 1: </label>
          <input type="textarea" name="TestCase1" id="TestCase"  style="display:block" required>

          <label for="TestAns"> Answer 1:</label>
          <input type="textarea" name="TestAns1" id="TestAns" required style="display:block" >
        

          <label for="TestCase"> Test Case 2: </label>
          <input type="textarea" name="TestCase2" id="TestCase"required style="display:block" >

         
          <label for="TestAns" > Answer 2: </label>
          <input type="textarea" name="TestAns2" id="TestAns" required style="display:block" >
        
          <h4> Optional Test Cases: </h4>
      
          <label for="TestCase3" id="LabelCase3" style="display:none;margin-bottom:0;" > Test Case 3: </label>
          <input type="textarea" name="TestCase3" id="TestCase3" style="display:none;margin-bottom:0;">
        
 
          <label for="TestAns3" id="LabelAns3" style="display:none;margin-bottom:0;"> Answer 3: </label>
          <input type="textarea" name="TestAns3" id="TestAns3" style="display:none;margin-bottom:0;">
       

          <label for="TestCase4" id="LabelCase4" style="display:none;margin-bottom:0;" > Test Case 4: </label>
          <input type="textarea" name="TestCase4" id="TestCase4" style="display:none;margin-bottom:0;" >

        
          <label for="TestAns4" id="LabelAns4"  style="display:none;margin-bottom:0;"> Answer 4: </label>
          <input type="textarea" name="TestAns4" id="TestAns4" style="display:none;margin-bottom:0;" >
      

          <label for="TestCase5" id="LabelCase5" style="display:none;margin-bottom:0;" > Test Case 5: </label>
          <input type="textarea" name="TestCase5" id="TestCase5" style="display:none;margin-bottom:0;" >

          <label for="TestAns5" id="LabelAns5" style="display:none;margin-bottom:0;" > Answer 5: </label>
          <input type="textarea" name="TestAns5" id="TestAns5" style="display:none;margin-bottom:0;" >
       
          <button id="addCase" type="button" name="addCase" style="margin-top:5px;width:50px;" onclick="addTest()" >+</button>
          <button id="remCase"  type="button" name="remCase" style="width:50px;" onclick="removeTest()">-</button>

          <button id="Submit" type="submit" name="Submit" style="width:150px;">Add Question</button>
        </form> 
      
      </div>
    </div>
    <h2>Question Bank</h2>
    <div class="column" id="qBank" >
  
  <?php foreach($_SESSION["qBank"] as $q): ?>
        <table id="qTable">
          <tr>
            <td class="qTitle">
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
            <td class="qTitle">
              <b> Topic: </b>
            </td>
            <td class="qInfo" >
              <?php echo $q->Topic . "<br>"; ?>
            </td>
          </tr>
          <tr>
            <td class="qTitle">
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

  </div>
  
</body>


<script>
  var optional_case = 3;

  function addTest(){
    
    if(optional_case > 5){
      return;
    }
    var newCase=document.getElementById("TestCase" + optional_case);
    //console.log(newCase.id);
    var newAns=document.getElementById("TestAns" + optional_case);
    var newCaseLabel=document.getElementById("LabelCase" + optional_case);
    var newAnsLabel=document.getElementById("LabelAns" + optional_case);
    
    newCase.style="display:block" ; 
    newCaseLabel.style="display:block" ; 
    newAns.style="display:block" ; 
    newAnsLabel.style="display:block" ; 
    
    if(optional_case < 5){
      optional_case++;
    }
   
  }

  function removeTest(){
   
    if(optional_case < 3){
      return;
    }
    var Case=document.getElementById("TestCase" + optional_case);
    //console.log(newCase.id);
    var Ans=document.getElementById("TestAns" + optional_case);
    var CaseLabel=document.getElementById("LabelCase" + optional_case);
    var AnsLabel=document.getElementById("LabelAns" + optional_case);
    Case.value="";
    Ans.value="";
    Case.style="display:none;margin-bottom:0;";
    CaseLabel.style="display:none;margin-bottom:0;";
    Ans.style="display:none;margin-bottom:0;";
    AnsLabel.style="display:none;margin-bottom:0;";
    
    if(optional_case > 3){
      optional_case--;
    }
   
  }

</script>