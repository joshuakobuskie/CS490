<?php require(  __DIR__ . "/partials/nav.php"); ?>

<?php 
    //check status of exam (graded, submitted, released, incomplete)
    function isTaken($EID){
        if($_SESSION["Role"] == "Student"){

            $data = array(
                'ID' => $_SESSION["ID"],
                'EID' => $EID
            
            );  

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestStatus.php');
            //POST newly created question data to middle
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //GET validation from middle
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response=json_decode($response);
        
        }
        return $response;
    }

?>
<head>
    <div class="title">
        <h1>Assignments</h1>
        <?php if($_SESSION["Response"]!=""): ?>
            <h3 class="message" >
                <?php 
                    echo $_SESSION["Response"];
                    $_SESSION["Response"] = ""; 
                    
                ?>

            </h3>
        <?php endif; ?>
    </div>

</head>

<body>
    <?php  foreach($_SESSION["exams"] as $e) : ?>
    <div class="center">   
        <div class="exam">    
            <div class="center">    
                <div class="row">
                    <?php  if($e->EID): ?>
                        <div id="examID" class="column">
                            <?php echo "<b>" . "Exam " . $e->EID . "</b>" . "<br>" ?>
                        </div>

                        <div id="examOptions" class="row">
                    
                            <?php if($_SESSION["Role"] == "Teacher"): ?>
                                
                                <form action="exam_data.php" method="post">
                                    <button id="viewExam" name="EID" value="<?php echo $e->EID ?>">Preview Exam</button>
                                </form>
                            
                                <form action="trigger_autoGrade.php" method="post">
                                    <button id="viewExam" name="EID" value="<?php echo $e->EID ?>">Auto Grade</button>
                                </form>

                                <form action="trigger_release.php" method="post">
                                    <button id="viewExam" name="EID" value="<?php echo $e->EID ?>">Release Grades</button>
                                </form>

                                <form action="v_all_results_data.php" method="post">
                                    <button id="viewExam" name="EID" value="<?php echo $e->EID ?>">Class Results</button>
                                </form>
                            
                            <?php endif; ?>
                            
                            <?php if($_SESSION["Role"] == "Student"): ?>
                                <?php if( isTaken($e->EID) == "Incomplete"): ?>
                                    <form action="exam_data.php" method="post">
                                        <button id="viewExam" name="EID" value="<?php echo $e->EID ?>">Take Exam</button>
                                    </form>

                                <?php elseif( isTaken($e->EID) == "Released"):  ?>
                                    <p style="padding-top:5px;" >Graded</p>
                                    <form action="v_results_data.php" method="post">
                                        <button id="viewExam" name="EID" value="<?php echo $e->EID; ?>">Your Results</button>
                                    </form>
                                <?php else: ?>

                                    <p style="padding:5px;" > Grade Pending </p>

                                <?php endif; ?>
                                
                            <?php endif; ?>
                            
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
    <?php endforeach; ?>
</body>









