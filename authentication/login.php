<?php
    session_start();
    require('../lib/Flash.php');
    require('../lib/Users.php');
    require('../lib/History.php');
   
    $bad = false;
    $data = array();
    $user = array();
    $history = array();
    date_default_timezone_set("America/Chicago");
    $date = date("l jS \of F Y h:i:s A");

    $historyData = History::openHistory($history);
    $hist_id = 0;    //**********************checking for last used id
    foreach ($historyData as $idNum) {
        if ( $idNum->id > $hist_id ) {
            $hist_id = $idNum->id;
        }
    }       

    $fullGoodUsers = Users::open($user);
    /*array_pop($fullGoodUsers);*/

    if (isset($_POST['username'], $_POST['password'])) { // fires if Biag logs in as superuser
        $bad = true;
        if ($_POST['username'] == 'biag' && $_POST['password'] == '1234') {
            $_SESSION['loggedin'] = true;
            $_SESSION['superUser'] = true;
            History::addHistory($date, $hist_id);
            Flash::set_notice("Hello Biag, you are now logged in!");     
            header("location: ../index.php");    
            exit;
        } 
        if ( $_POST['username'] != 'biag' ) { 
            foreach ( $fullGoodUsers as $foo ) {
                if ( ( $_POST['username'] == $foo->username  ) && ( $_POST['password'] == $foo->password ) ) { // fires if valid user logs in
                    $_SESSION['superUser'] = false;
                    $_SESSION['loggedin'] = true;
                    History::addHistory($date, $hist_id);
                    Flash::set_notice("You are now logged in!");                
                    header("location: ../index.php");
                    exit;  
                } 
            }
        } 
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="../style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="../style_sheets/login.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
</head>
<body>
    <a class="home" href="../index.php">Home</a>
    <?php if ($bad) : ?>            <!-- error message if login fails -->
        <div class="flashalert"><p>The username or password is not correct</p></div>
    <?php endif ?>
    <div class="mainLoginBox">
        <div class="loginBox">
            <h1>Please login</h1>
            <form action="login.php" method="post">
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" value="" id="username">
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name="password" value="" id="password">
                </p>
                <p>
                    <input type="submit" value="Login">
                </p>
            </form>
        </div>
        <?php
        if (isset($_SESSION['flash'])) {          // here for future development  
            echo '<div class="flash' . $_SESSION['flash']['type'] . '">';
            echo '<p>' . $_SESSION['flash']['message'] . '</p>';
            echo '</div';
            unset($_SESSION['flash']);
        } 
        ?> 
    </div>
</body>
</html>