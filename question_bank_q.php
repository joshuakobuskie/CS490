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


$responseTest=(array)$response;


?>

<div>


<?php if(!empty($responseTest)): ?>
    <?php foreach($response as $q): ?>
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
<?php else: ?>
    <?php echo "<h2>" . "No Results" . "<h2>"; ?>
<?php endif; ?>
</div>
