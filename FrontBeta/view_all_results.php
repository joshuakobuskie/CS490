<?php require(  __DIR__ . "/partials/nav.php"); ?>

<?php 
    function isTaken($ID, $EID){
        if($_SESSION["Role"] == "Teacher"){

            $data = array(
                'ID' => $ID,
                'EID' => $EID
            
            );  

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestStatus.php');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response=json_decode($response);
        }
        return $response;
    }

?>

<head>
        <div class="title">
            <h1> <?php echo "Exam " . $_SESSION["EID"] . " results"; ?></h1>
        </div>
       
    </head>

    <body>
        <?php  foreach($_SESSION["all_results"] as $r) : ?>
        <div class="center">   
            <div class="exam">    
                <div class="center">    
                    <div class="row">
                        <?php  if($r->ID): ?>
                            <div id="examID" class="column">
                                <?php echo "<b>" . $r->Username . "</b>" . "<br>" ?>
                            </div>

                            <div id="examOptions" class="row">
                                <p style="padding-top:5px;"><?php echo isTaken($r->ID, $r->EID); ?>
                                <?php if($_SESSION["Role"] == "Teacher" && isTaken($r->ID, $r->EID) != "Incomplete"): ?>
                                    
                                    <form action="v_results_data.php" method="post">
                                        <button id="viewExam" name="ID" value="<?php echo $r->ID ?>">View Results</button>
                                        <?php $_SESSION["EID"] = $r->EID;?>
                                    </form>
                                <?php else: ?>
                                    <p style="padding:5px;">Not Yet Graded</p>
                                <?php endif; ?>
                            
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
       
          
        <?php endforeach; ?>
                     

    </body>
