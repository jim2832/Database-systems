<?php

session_start();
$logout = isset($_POST['logout']);

if($logout){
    session_destroy();
    header("Refresh: 0; URL=login.html");
    exit();
}

?>