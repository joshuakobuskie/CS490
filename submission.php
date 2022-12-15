<?
  session_start();
  require( __DIR__ . "/functions.php");
$data = array(
        "ID" => $_SESSION["ID"],
        "EID" => 91,
        "QID" => 2

        
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://afsaccess4.njit.edu/~lg296/middleRequestSubmission.php');
    //POST newly created question data to middle
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //GET validation from middle
    $response = curl_exec($ch);
    

    $response=json_decode($response);
    print_r($response);
?>