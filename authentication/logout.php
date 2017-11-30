<?php
    session_start();
    require('../lib/Flash.php');

    unset($_SESSION['loggedin']);  // removes logged in from session 
    Flash::set_notice("You are now logged out!");
    header("location: ../index.php");   // redirects to index without logged in
    exit;
?>