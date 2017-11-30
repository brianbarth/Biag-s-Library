<?php
    session_start();
    require('lib/Books.php');
    require('lib/Flash.php');
    require('lib/Authentication.php');

    Authentication::authenticate();

    $filename = "assets/bookData.txt";     //variable declarations
    $info = array();
    $errors = array();
    $bookR = null;
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
      
        //overwrites empty array with field data, if exists inserts data into form fields
        extract( $_POST, EXTR_IF_EXISTS );

        //validation
        $errors = Books::validate($_POST); //object call for validation
        
        if (count($errors) == 0) {
            Flash::set_notice("New book created!"); 
            //open and loads book data             
            $info = Books::open($info);
   
            $last_id = 0;    //**********************checking for last used id

            foreach ($info as $idNum) {
                if ( $idNum->id > $last_id ) {
                    $last_id = $idNum->id;
                }
            }             
            //write to the text file
            Books::append($info, $last_id); //object call to append new data to file


        } else {
            foreach ( $errors as $mssg ) {
                echo "<div class='errorBox'>" . "<p class='errorPrint'>" . $mssg . "</br>" . "</p></div>";
            }
        } //end of loop that prints $errors array
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="style_sheets/newStyle.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <title>New Book</title>
</head>
<body>
    <div class="main">
        <div class="navigation">        
        <div class="oval"><h1>Biag's Books</h1></div>
            <nav>
                <ul>
                    <li class="new"><a href="new.php">New</a></li>
                    <li class="home"><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
        <div class="newBox">
            <form action="new.php" method="post">     <!--form and error styling -->
            
                <?php $errors = Books::form($errors, $bookR); ?> <!--Form creation from Books Class form function-->
                
                
                    <div class="choiceBox">
                        <input type="submit" value="Save New Book">
                    </div>
              
    
            </form>
        </div>
    </div>
</body>
</html>