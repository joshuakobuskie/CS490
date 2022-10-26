<?php

function redirect($path)
{ 
    if (!headers_sent()) {
        //php redirect
        header("Location: " . $path);
        exit();
    }
    //javascript redirect
    echo "<script>window.location.href='" . $path . "';</script>";
    //metadata redirect (runs if javascript is disabled)
    echo "<noscript><meta http-equiv=\"refresh\" content=\"0;url=" . $path . "\"/></noscript>";
    exit();
}

?>