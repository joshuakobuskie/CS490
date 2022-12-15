<?php 
session_start();

$data=array(
    'Topic' => $_POST["TopicSelect"],
    'Difficulty' => $_POST["DifficultySelect"],
    'Keyword' => $_POST["Keyword"]
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestQuestions.php');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$response=json_decode($response);

$_SESSION["qBank"] = $response;
?>

<div>
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
        <?php if($q->QConstraint!=""): ?>
            <tr>
              <td class="qTitle">
              <b> Constraint: </b>
              </td>
              <td class="qInfo" >
              <?php echo $q->QConstraint; ?>
              </td>
            </tr> 
            <?php endif;?>
        </table>
        <br>
    <?php endforeach; ?>
</div>
