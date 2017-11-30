<?php
    session_start();
    require('lib/Books.php');
    require('lib/Flash.php');
    require('lib/Authentication.php');

    Authentication::authenticate();

    $filename = "assets/bookData.txt";  
    $info = array();

    if ( ! isset ($_GET['id'])) {
        Flash::set_alert("The book could not be found");
        header ('location: index.php');
        exit;
    } else {
        Flash::set_notice("The book was deleted!");
    }
    
    // loads all of the book data
    $info = Books::open($info); // opens book data

    Books::remove($info);  // rewrites file after deleting entry
    
?>