<?php
    session_start();
    require('../lib/Flash.php');
    $file = fopen( "loginHistory.txt", "w"); 
    fwrite($file, '');
    fclose($file);

    Flash::set_notice("History has been deleted!");
    header("location: addUser.php");
    exit;   
?>