<?php require(  __DIR__ . "/partials/nav.php"); ?>

<head>

<h1>
    Exam 
    <?php 
        $qPossible;
        $qActual;
        $numQs=0;
        foreach($_SESSION["exam"] as $q){
            echo $q->EID;
         
            for($i=1; $i<=5; $i++){
                if(( $_SESSION["user_results" . $i]->EID == $_SESSION["EID"] )){
                    
                    $results = $_SESSION["user_results" . $i];
                    if($_SESSION["user_results" . $i]->QID == $q->QID){
                        $numQs++;
                        $qPossible += $results->NamePossible + $results->Case1Possible + $results->Case2Possible + 
                        $results->Case3Possible + $results->Case4Possible + $results->Case5Possible;

                        $qActual += $results->NamePoints + $results->Case1Points + $results->Case2Points + 
                        $results->Case3Points + $results->Case4Points + $results->Case5Points;
                
                    }
                }
            }
        }
    ?>
    Results
</h1>
<h2>
    
<?php echo "Score: " . $qActual . "/" . $qPossible; ?>

</h2>
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
    
    <?php $qNum=1; ?>
    <form id="edit_results" method="post" action="edit_results.php">
        
        <?php for($i=1; $i <= 5 ; $i++): ?>

            <?php if(( $_SESSION["user_results" . $i]->EID == $_SESSION["EID"] )): ?>
                <?php if($_SESSION["user_results" . $i] != ""): ?>
                    <div class="column answers">
                        
                        <?php foreach($_SESSION["exam"] as $q): ?>
                            <?php if($q->QID != ""): ?> 
                                <?php if($_SESSION["user_results" . $i]->QID == $q->QID): ?>
                                    
                                    <!-- print question -->
                                    <?php echo "<h3>Question: " . $qNum . "</h3>";
                                    echo " Write a function named " . $q->Name . " that takes the parameter(s) " . $q->Parameters . " and returns " . $q->ReturnValue . "<br><br>";
                                    
                                    $qNum++;
                        
                                    $expected[0]=$q->Name;
                                    $expected[1]=$q->Test1 . " => " . $q->Ans1 ;
                                    $expected[2]=$q->Test2 . " => " . $q->Ans2;
                                    $expected[3]=$q->Test3 . " => " . $q->Ans3;
                                    $expected[4]=$q->Test4 . " => " . $q->Ans4;
                                    $expected[5]=$q->Test5 . " => " . $q->Ans5;
                                
                                    ?>
                                    <!-- print answer -->
                                    <?php //for($k=1; $k <= 5 ; $k++): ?>
                                        <?php if(( $_SESSION["user_results" . $i]->EID == $_SESSION["EID"] )): ?>
                                            <?php if($_SESSION["user_results" . $i]->QID == $q->QID): ?>
                                                <b>Answer:</b>
                                                <pre style="height:200px;overflow:auto;">
                                                    <?php $answer=$_SESSION["user_results" . $i]->Answer;?>
                                                    <?php echo  "<br>" . $answer;?>
                                                </pre>

                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php //endfor;?>

                                <?php endif;?> 
                            
                            <?php endif;?>
            
                        <?php endforeach; ?>    
                    
                    </div>
            
                    <!-- ---------------------------------------------------------------------------------------- -->
                
                    <?php 
                        $possiblePoints=0; 
                        $actualPoints=0;
                        $j=1;
                    ?> 
                    <div class="column results">  
                        <?php 
                            $results = $_SESSION["user_results" . $i];
                            
                            $possiblePoints += $results->NamePossible + $results->Case1Possible + $results->Case2Possible + 
                            $results->Case3Possible + $results->Case4Possible + $results->Case5Possible;
                            $actualPoints += $results->NamePoints + $results->Case1Points + $results->Case2Points + 
                            $results->Case3Points + $results->Case4Points + $results->Case5Points;        
                        ?>
                        <br><br>
                        <table id="resultsTable">
                            <tr class="results_td" >
                                <td class="results_td" >
                                    <b>Case
                                </td>
                                <td class="results_td" >
                                    <b>Expected Output
                                </td>
                                <td class="results_td" >
                                    <b>Actual Ouput
                                </td>
                                <td class="results_td" >
                                    <b>Possible Points
                                
                                </td>
                                <td class="results_td" >
                                    <b>Points Given
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="results_td">
                                    Name
                                </td>
                                <td class="results_td" >
                                    <?php echo $expected[0];?>
                                </td>
                                <td class="results_td" >

                                <?php echo $results->NameResult; ?>
                                </td>
                                <td class="results_td" >
                                    <?php echo $results->NamePossible; ?>
                                </td>
                                <td class="results_td" >
                                    <?php if($_SESSION["Role"] == "Teacher"): ?>
                                        <input step="0.01" type="number" name="<?php echo 'NamePoints' . $i ;?>"  value="<?php echo $results->NamePoints;?>" style="width:90px;">
                                    <?php else: ?>
                                        <?php echo $results->NamePoints; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="results_td" style="text-align:center;">
                                    <?php if($results->NamePoints == "0" ): ?>
                                        <p style="color:red;">&#9746;</p>
                                    <?php elseif($results->NamePoints != $results->NamePossible ): ?>
                                        <p style="color:orange;">&#9745;</p>
                                    
                                    <?php else: ?>
                                        <p style="color:green;">&#9745;</p>
                                    <?php endif; ?>
                                </td>
                            
                            </tr>
                            <tr>
                                <td class="results_td">
                                    1
                                </td>
                                <td class="results_td" >
                                    <?php echo $expected[1] ;?>
                                </td>
                                <td class="results_td" >
                                <?php echo $results->Case1Result; ?>
                                </td>
                                <td class="results_td" >
                                    <?php echo $results->Case1Possible; ?>
                                </td>
                                <td class="results_td" >
                                    <?php if($_SESSION["Role"] == "Teacher"): ?>
                                        <input step="0.01" type="number" name="<?php echo 'Case1Points' . $i ;?>" value="<?php echo $results->Case1Points;?>" style="width:90px;">
                                    <?php else: ?>
                                        <?php echo $results->Case1Points; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="results_td" style="text-align:center;">
                                    <?php if($results->Case1Points == "0" ): ?>
                                        <p style="color:red;">&#9746;</p>
                                    <?php elseif($results->Case1Points != $results->Case1Possible ): ?>
                                        <p style="color:orange;">&#9745;</p>
                                    <?php else: ?>
                                        <p style="color:green;">&#9745;</p>
                                    <?php endif; ?>
                                </td>
                            
                            </tr>
                            <tr>
                            <td class="results_td">
                                    2
                                </td>
                                <td class="results_td" >
                                    <?php echo $expected[2];?>
                                </td>
                                <td class="results_td" >
                                <?php echo $results->Case2Result; ?>
                                </td>
                                <td class="results_td" >
                                    <?php echo $results->Case2Possible; ?>
                                </td>
                                <td class="results_td" >
                                    <?php if($_SESSION["Role"] == "Teacher"): ?>
                                        <input step="0.01" type="number" name="<?php echo 'Case2Points' . $i ;?>" value="<?php echo $results->Case2Points;?>" style="width:90px;">
                                    <?php else: ?>
                                        <?php echo $results->Case2Points; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="results_td" style="text-align:center;">
                                    <?php if($results->Case2Points == "0" ): ?>
                                        <p style="color:red;">&#9746;</p>
                                    <?php elseif($results->Case2Points != $results->Case2Possible ): ?>
                                        <p style="color:orange;">&#9745;</p>
                                    <?php else: ?>
                                        <p style="color:green;">&#9745;</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if($results->Case3Result != ""): ?>
                                <tr>
                                    <td class="results_td">
                                        3
                                    </td>
                                    <td class="results_td" >
                                        <?php echo $expected[3];?>
                                    </td>
                                    <td class="results_td" >
                                        <?php echo $results->Case3Result; ?>
                                    </td>
                                    <td class="results_td" >
                                        <?php echo $results->Case3Possible; ?>
                                    </td>
                                    <td class="results_td" >
                                        <?php if($_SESSION["Role"] == "Teacher"): ?>
                                            <input step="0.01" type="number" name="<?php echo 'Case3Points' . $i ;?>" value="<?php echo $results->Case3Points;?>" style="width:90px;">
                                        <?php else: ?>
                                            <?php echo $results->Case3Points; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="results_td" style="text-align:center;">
                                        <?php if($results->Case3Points == "0" ): ?>
                                            <p style="color:red;">&#9746;</p>
                                        <?php elseif($results->Case3Points != $results->Case3Possible ): ?>
                                            <p style="color:orange;">&#9745;</p>
                                        <?php else: ?>
                                            <p style="color:green;">&#9745;</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if($results->Case4Result != ""): ?>
                            <tr>
                                <td class="results_td">
                                    4
                                </td>
                                <td class="results_td" >
                                    <?php echo $expected[4] ;?>
                                </td>
                                <td class="results_td" >
                                <?php echo $results->Case4Result; ?>
                                </td>
                                <td class="results_td" >
                                    <?php echo $results->Case4Possible; ?>
                                </td>
                                <td class="results_td" >
                                    <?php if($_SESSION["Role"] == "Teacher"): ?>
                                        <input step="0.01" type="number" name="<?php echo 'Case4Points' . $i ;?>" value="<?php echo $results->Case4Points;?>" style="width:90px;">
                                    <?php else: ?>
                                        <?php echo $results->Case4Points; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="results_td" style="text-align:center;">
                                    <?php if($results->Case4Points == "0" ): ?>
                                        <p style="color:red;">&#9746;</p>
                                    <?php elseif($results->Case4Points != $results->Case4Possible ): ?>
                                        <p style="color:orange;">&#9745;</p>
                                    <?php else: ?>
                                        <p style="color:green;">&#9745;</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if($results->Case5Result != ""): ?>
                            <tr>
                                <td class="results_td">
                                    5
                                </td>
                                <td class="results_td" >
                                    <?php echo $expected[5] ;?>
                                </td>
                                <td class="results_td" >
                                <?php echo $results->Case5Result; ?>
                                </td>
                                <td class="results_td" >
                                    <?php echo $results->Case5Possible; ?>
                                </td>
                                <td class="results_td" >
                                    <?php if($_SESSION["Role"] == "Teacher"): ?>
                                        <input step="0.01" type="number" name="<?php echo 'Case5Points' . $i ?>" value="<?php echo $results->Case5Points;?>" style="width:50px;">
                                    <?php else: ?>
                                        <?php echo $results->Case5Points; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="results_td" style="text-align:center;">
                                    <?php if($results->Case5Points == "0" ): ?>
                                        <p style="color:red;">&#9746;</p>
                                    <?php elseif($results->Case5Points != $results->Case5Possible ): ?>
                                        <p style="color:orange;">&#9745;</p>
                                    <?php else: ?>
                                        <p style="color:green;">&#9745;</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        
                            <?php endif; ?> 
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>  <b><?php echo $possiblePoints?> </td>
                                <td>  <b><?php echo $actualPoints?>   </td>
                                <td><b>Total</td>
                            </tr>
                        </table>
                
                        <div id="q_comments">
                            <b> Comments: </b><br>
                            <?php if($_SESSION["Role"] == "Teacher"): ?>
                                <textarea class="comments" name="<?php echo 'Comments' . $i?>" value="<?php echo $results->Comments;?>" ><?php echo $results->Comments;?></textarea>
                            <?php else: ?>
                                <?php echo $results->Comments; ?>
                            <?php endif; ?>
                            <?php $j++; ?>
                        </div> 
                    </div>  
                <?php endif;?>
                
                <input hidden name="ID" value="<?php echo $results->ID?>">
                <input hidden name="EID" value="<?php echo $results->EID?>">
                <input hidden name="<?php echo 'QID' . $i?>" value="<?php echo $results->QID?>">
                <input hidden name="<?php echo 'NameResult' . $i ;?>" value="<?php echo $results->NameResult?>">
                <input hidden name="<?php echo 'NamePossible' . $i ;?>" value="<?php echo $results->NamePossible?>">
                <input hidden name="<?php echo 'Case1Result' . $i ;?>" value="<?php echo $results->Case1Result?>">
                <input hidden name="<?php echo 'Case1Possible' . $i ;?>" value="<?php echo $results->Case1Possible?>">
                <input hidden name="<?php echo 'Case2Result' . $i ;?>" value="<?php echo $results->Case2Result?>">
                <input hidden name="<?php echo 'Case2Possible' . $i ;?>" value="<?php echo $results->Case2Possible?>">
                <input hidden name="<?php echo 'Case3result' . $i ;?>" value="<?php echo $results->Case3Result?>">
                <input hidden name="<?php echo 'Case3Possible' . $i ;?>" value="<?php echo $results->Case3Possible?>">
                <input hidden name="<?php echo 'Case4result' . $i ;?>" value="<?php echo $results->Case4Result?>">
                <input hidden name="<?php echo 'Case4Possible' . $i ;?>" value="<?php echo $results->Case4Possible?>">
                <input hidden name="<?php echo 'Case5result' . $i ;?>" value="<?php echo $results->Case5Result?>">
                <input hidden name="<?php echo 'Case5Possible' . $i ;?>" value="<?php echo $results->Case5Possible?>">
            <?php endif; ?>

        
        <?php endfor;?>  <!-- end main for loop -->

        <div class="column answers"> </div>
        <div class="column results">
            <?php if($_SESSION["Role"] == "Teacher"): ?>
                <button type="Submit" name="Submit" style="margin-top:25px;width:140px;height:30px;">Update Grade</button>
            <?php endif; ?>
        </div>
        
    </form>
   

</div>


</body>