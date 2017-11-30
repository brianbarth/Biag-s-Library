<?php 
    session_start();
    require('../lib/History.php');
    $user = array();
    date_default_timezone_set("America/Chicago");
    $date = date("l jS \of F Y h:i:s A");
    $history = array();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login History</title>
    <link rel="stylesheet" href="../style_sheets/history.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
</head>
<body>
    <?php

      $history = History::openHistory($history);

    ?>

    <main>
        <a class="home" href="addUser.php">Users</a> 
        <a class="home" href="../index.php">Home</a>
        <a class="home" href="deleteHistory.php">Delete History</a>
        <h1>Login History</h1>
        <div class="table">
            <table>
                <col><col>
                <tr>
                    <th>User</th>
                    <th>Date/Time of login</th>
                </tr>                        
                <?php foreach ($history as $foo) : ?>
                    <tr>
                    <?php echo "<td>" . $foo->username . "</td>"; ?> 
                    <?php echo "<td>" . $foo->date . "</td>"; ?>                                             
                    <!--<td><p class="delete"><span><a href="deleteUser.php?id=<?php echo $foo->id ?>">DEL</a></span></p></td>-->
                    </tr>                       
                <?php endforeach ?>            
            </table>   
        </div> 
    </main>
</body> 
</html> 