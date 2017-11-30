<?php
 

    session_start();
    require('lib/Books.php'); /*loads the objects page */
    require('lib/Authentication.php');
    require('lib/Flash.php');

    $info = Books::open($info); // opens data
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="style_sheets/style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
</head>
<body>
    <div class="main">
        <div class="navigation">        
            <div class="oval"><h1>Biag's Books</h1></div>
            <nav>
                <ul>
                    <?php if ( ! Authentication::loggedin() ) : ?>
                    <li class="new"><a href="authentication/login.php">Login</a></li>
                    <? else : ?>
                    <li class="new"><a href="authentication/logout.php">Logout</a></li>
                    <?php endif ?>

                    <?php if ( Authentication::loggedin() ) : ?>
                    <li class="new"><a href="new.php">New</a></li>
                    <?php endif ?>
                    <?php if ( Authentication::loggedin() && $_SESSION['superUser'] == true ) : ?> 
                    <li class="users"><a href="authentication/addUser.php">Users</a></li>
                    <?php endif ?>                    
                    <li class="search"><a href="search.php">Search</a></li>                   
                </ul>               
            </nav>
        </div>                
        <div class="bookBox">
            <div class="tableDiv">
                <table class="books">
                    <tr>
                        <th colspan="3">Title</th>                 
                    </tr>
            
                <?php Books::listBooks($info); ?>  <!-- creates list of book titles -->
                </table>
            </div>
        </div>
        <?php
            if (isset($_SESSION['flash'])) {
                echo '<div class="flash' . $_SESSION['flash']['type'] . '">';
                echo '<p>' . $_SESSION['flash']['message'] . '</p>';
                echo '</div';
                unset($_SESSION['flash']);
            } 
        ?>  
    </div>
     
</body>
</html>