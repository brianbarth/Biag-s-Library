<?php
    session_start();
    require('../lib/Users.php');
    require('../lib/Flash.php');
    require('../lib/Authentication.php');

    Authentication::authenticate();

    $user = array();

    if ( ! isset ($_GET['id'])) {
        Flash::set_alert("The user does not exist");    //sets flash message as failure
        header ('location: index.php');
        exit;
    } else {
        Flash::set_notice("The user was deleted!"); //sets flash message as success
    }
    
    // loads all of the user data
    $user = Users::open($user); // opens user data

    Users::remove($user);  // rewrites file after deleting user
    
?>