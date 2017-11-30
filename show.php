<?php
    session_start();
    require('lib/Books.php');
    require('lib/Flash.php');
    require('lib/Authentication.php');
    $info = array();
    $assInfo = array();
    $chosenInfo = null;

    if ( !isset( $_GET['id'])) {
        Flash::set_alert("The Book could not be found");
        header( "location: index.php" );
        exit;
    }
       $info = Books::open($info); // opens all files
       $chosenInfo = $info[$_GET['id']]; // finds chosed book by passed string query
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="style_sheets/showStyle.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
    <title><?php echo $chosenInfo->title ?></title>
</head>
<body>
    <div class="main">
        <div class="navigation">        
        <div class="oval"><h1>Biag's Books</h1></div>
            <nav>
                <ul> 
                    <?php if (Authentication::loggedin() ) : ?>     
                    <li class="new"><a href="new.php">New</a></li>            
                    <?php endif ?>
                    <li class="home"><a href="index.php">Home</a></li>
                    
                </ul>
            </nav>
        </div>
        <div class="showContent">
            <h2>BOOK INFORMATION</h2>
            <div class="cDiv">
                <p><span class="underline">TITLE:</span> <?php echo htmlentities($chosenInfo->title) ?></p> 
                <p><span class="underline">AUTHOR:</span>  <?php echo htmlentities($chosenInfo->author) ?></p>
                <p><span class="underline">PUBLISHER:</span>  <?php echo htmlentities($chosenInfo->publisher) ?></p>       
                <p><span class="underline">ISBN:</span>  <?php echo htmlentities($chosenInfo->ISBN) ?></p>
            </div>
            <div class="choiceBox">
                <?php if (Authentication::loggedin() ) : ?>                    
                <p class="edit"><span><a href="edit.php?id=<?php echo $chosenInfo->id ?>">EDIT</a></span></p>
                <?php endif ?>
                <?php if (Authentication::loggedin() ) : ?> 
                <p class="delete"><span><a href="delete.php?id=<?php echo $chosenInfo->id ?>">DEL</a></span></p>
                <?php endif ?>  
            </div>                                   
        </div>
        <?php
            if (isset($_SESSION['flash'])) {
                echo '<div class="flash' . $_SESSION['flash']['type'] . '" style="width:90%;margin:auto;">';
                echo '<p style="color:blue;font-size:24px;font-weight:bold;text-align:center;">' . $_SESSION['flash']['message'] . '</p>';
                echo '</div';
                unset($_SESSION['flash']);
            } 
        ?>       
    </div>

</body>
</html>