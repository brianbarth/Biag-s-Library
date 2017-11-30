<?php
    session_start();
    require('lib/Books.php');
    require('lib/Flash.php');
    require('lib/Authentication.php');

    Authentication::authenticate(); // calls the authenticate function for login 

    $errors = array();
    $bookR = Books::find($_GET['id']); // acquiring book data
      
    if (! $bookR) {                     //is there an ID?
        Flash::set_alert("The Book could not be found");
        header ("location: index.php");
        exit;
    }
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

    $errors = Books::validate($_POST); //validation
            
        if (count($errors) == 0) {  // writing clean file
            if( $bookR->update($_POST) ) {
                Flash::set_notice("The Book was updated!");
                header( "location: show.php?id=" . $bookR->id ); // redirects after writing
                exit;
            }
        } else {
            foreach ($errors as $foo) {         // validation-- prints error messages
                echo "<div class='errorBox'>" . "<p class='errorPrint'>" . $foo . "</br>" . "</p></div";
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
    <link rel="stylesheet" href="style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="style_sheets/edit.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <title>Edit Page</title>
</head>
<body>
    <div class="main">
        <div class="navigation">        
        <div class="oval"><h1>Edit Page</h1></div>
            <nav>
                <ul>
                    <li class="new"><a href="new.php">New</a></li>
                    <li class="home"><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
        <div class="editBox">
            <form action="edit.php?id=<?php echo $bookR->id ?>" method="post">     <!--form and error styling -->
               
                <?php Books::form($errors, $bookR); ?> <!--creating and populating the edit page form-->

                    <div class="choiceBox">
                        <input type="submit" value="Update Book">
                    </div>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
