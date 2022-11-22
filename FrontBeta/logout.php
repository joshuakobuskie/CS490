<?php
session_start();
require(__DIR__ . "/functions.php");

session_unset();
session_destroy();

redirect("index.php");

?>