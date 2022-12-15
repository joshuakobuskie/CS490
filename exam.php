<?php 
    session_start();

    if($_SESSION["Role"] == "Teacher"){
        require(  __DIR__ . "/partials/nav.php");
    }
    else{
        require("functions.php");
    }
    if($_SESSION["Logged_In"]!="true"){
        $_SESSION["Error"] = "You must be logged in to view this page";
        redirect("index.php");
    }

?>
    <head>
        <div class="title">
            <h1>
                <?php  
                    foreach($_SESSION["exam"] as $e){ 
                        if($e->EID){
                            echo "Exam " . $e->EID;
                            if($_SESSION["Role"] == "Teacher"){
                                echo " (Preview)";
                            }
                        }
                    }
                ?> 
            </h1>
        </div>
    
    </head>

    <body>

        <div class="row">
            </div>
                <div class="column qlinks">
                    <h2 style="margin-left: 20px;"> Questions: </h2>
                    
                    <?php $qNum = 1; ?>
                    <?php foreach($_SESSION["exam"] as $index => $q): ?>
                        <?php if($q->QID): ?>
                            <button class="qLinks" id=" <?php echo $qNum;?> " onclick="show_question(this)" value="<?php echo $qNum?>" > <? echo "Question " . $qNum ; ?> </button>
                            <br>
                            <?php $qNum++; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div> 
                <div class="column">
                    <form method="post" action="exam_submit.php">
                        <?php $qNum = 1; ?>
                        <?php foreach($_SESSION["exam"] as $e): ?>
                        
                            <?php foreach($_SESSION["exam"] as $index => $q): ?>
                                    <? if($q->QID != ""): ?>
                                        <?php if($qNum == 1): ?>
                                            <div class="dispQ"  id="<?php echo 'q' . $qNum; ?>">
                                        <?php else:  ?>
                                            <div class="dispQ"  id="<?php echo 'q' . $qNum; ?>" hidden>
                                        <?php endif;?>
                                            <h3> <?php echo "Question: " . $qNum  . " (" . $q->Points . " Points)" . "<br>" ;?> </h3>
                                            <?php echo "Write a function named " . $q->Name . " that takes the parameter(s) " . $q->Parameters . " and returns " . $q->ReturnValue; ?>
                                            <br><br>
                                            <?php if($q->QConstraint!=""): ?>
    
                                               
                                                <b> Constraint: </b>
                                                
                                                <?php echo "Must use " .$q->QConstraint; ?>
                                               
                                            <?php endif;?>
                                            
                                                <?php if($_SESSION["Role"]=="Student") : ?>
                                                    <span>
                                                        <input type="hidden" id="QID<?php echo $qNum ?>" name="QID<?php echo $qNum ?>"  value="<?php echo $q->QID; ?>" ></input>
                                                        <textarea class="fill" type="textarea" id="Answer<?php echo $qNum ?>" name="Answer<?php echo $qNum; ?>"></textarea>
                                                    </span>
                                                <?php endif; ?>
                                                <br>
                                            

                                        </div>
                                        <?php $qNum++; ?>
                                <?php endif; ?>
                                
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php if($_SESSION["Role"]=="Student") : ?>
                            <button id="Submit_Exam" name="Submit" type="submit" style="width:100px;display: block; margin: 0 auto;">Submit Exam </button>\
                        <?php endif; ?>
                    </form>
                </div> 
        </div>
    
    </body>
        
    
<script>
    var fill= document.getElementById("Answer1");
    if(fill.value ==""){
        console.log("empty");
    }
    console.log(fill.value);
    var fill_ins = document.getElementsByClassName("fill");

    for (var i = 0; i < fill_ins.length; i++) {
        fill_ins[i].addEventListener('keydown', function(e) {
            if (e.key == 'Tab') {
                e.preventDefault();
                var start = this.selectionStart;
                var end = this.selectionEnd;

                // set textarea value to: text before caret + tab + text after caret
                this.value = this.value.substring(0, start) + "\t" + this.value.substring(end);

                // put caret at right position again
                this.selectionStart =
                this.selectionEnd = start + 1;
            }
        });
    }

    function show_question(question){
        var allLinks= document.getElementsByClassName("dispQ");
        var desired_q = document.getElementById("q" + question.value);
        for(var i = 0; i < allLinks.length; i++){
             if(allLinks[i].id == "q" + question.value){
                allLinks[i].hidden=false;
            } 
            allLinks[i].hidden=true;
        }
    
        desired_q.hidden=false;
    }

    document.getElementById("Submit_Exam").addEventListener('click', function(e) { 
        var confirm = window.confirm("Are you sure you would like to submit?");
        if(!confirm){
            e.preventDefault();
        }
    }); 

</script>