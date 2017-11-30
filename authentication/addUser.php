<?php
    session_start();
    require('../lib/Users.php');
    require('../lib/Flash.php');
  

    $user = array();

    if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {     
          //overwrites empty array with field data, if exists inserts data into form fields
          extract( $_POST, EXTR_IF_EXISTS );

    $user = Users::open($_POST);
    
    $last_id = 0;    //**********************checking for last used id
    
       foreach ($user as $idNum) {
            if ( $idNum->id > $last_id ) {
                $last_id = $idNum->id;
            }
        } 
   
    Users::append($user, $last_id); //object call to append new data to file*/
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
    <link rel="stylesheet" href="../style_sheets/addUser.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
</head>
<body>
    <a class="home" href="../index.php">Home</a>
    <a class="home" href="history.php">History</a>
    <div class="mainLoginBox">   <!-- form for adding new users -->
        <div class="loginBox">
            <h1>Add a new authorized user</h1>
            <form action="addUser.php" method="post">
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" value="" id="username">
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name="password" value="" id="password">
                </p>
                <p>
                    <input type="submit" value="Add">
                </p>
            </form>
        </div>
    </div>
    <div class="mainLoginBox">      <!-- displays list of users -->
        <div class="userBox">
            <h1>List of approved users</h1>
            <table>
                <tr>
                    <th>User</th>
                    <th>Password</th>
                </tr>            
                <?php $user = Users::open($_POST); ?>   <!-- populates user table -->
                <?php foreach ($user as $foo) : ?>
                    <tr>
                    <?php echo "<td>" . $foo->username . "</td>"; ?> 
                    <?php echo "<td>" . $foo->password . "</td>"; ?>                                             
                    <td><p class="delete"><span><a href="deleteUser.php?id=<?php echo $foo->id ?>">DEL</a></span></p></td>
                    </tr>                       
                <?php endforeach ?>            
            </table>
        </div>
        <?php
            if (isset($_SESSION['flash'])) {      //  renders flash message 
                echo '<div class="flash' . $_SESSION['flash']['type'] . '">';
                echo '<p>' . $_SESSION['flash']['message'] . '</p>';
                echo '</div';
                unset($_SESSION['flash']);
            } 
        ?> 
    </div>
</body>
</html>