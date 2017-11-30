<?php
    $file = "assets/bookData.txt";
    $matches = array();
    $count = "";
    $selection = $_POST['pattern'];  // sets variable from Form, user defined character to search
    if (isset($selection)) {    //determines if variable exists
        $var = file($file);        // creates indexed array from file data
        foreach ($var as $line) {       // iterates through data array
            if (preg_match('/' . $selection . '/i', trim($line))) {  // user search criteria :against: file array less white space
                    array_push($matches, trim($line));   // pushes any matches to matches array                        
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
    <title>Search</title>
    <link rel="stylesheet" href="style_sheets/allPage.css" type="text/css">
    <link rel="stylesheet" href="style_sheets/search.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
</head>
<body>
    <div class="main">
        <div class="navigation">        
        <div class="oval"><h1>Search Biag's Books</h1></div>
            <nav>
                <ul>
                    <li class="home"><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
        <div class="showContent">
            <form class="searchForm" action="search.php" method="post">
                <input type="text" id="pattern" value="<?php echo $selection ?>" name="pattern">
                <div class="choiceBox">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
        <?php if(count($matches) > 0) : ?>
            <div class="results">           
                <table>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>ISBN</th>
                        </tr>
                    <?php foreach ($matches as $match) : ?> <!-- iterates through matches array -->
                        <tr>
                            <?php $fields = explode('~', $match) ?> <!-- parsing out matching data from line -->
                            <?php array_shift($fields); ?> <!-- removes and returns first element of matches array -->
                            <?php foreach ($fields as $data) : ?> <!-- iterates through delineated data-->
                                <?php if (preg_match('/' . $selection . '/i', $data)) : ?> <!-- if match change style -->
                                    <td class="bgColor"><?php echo $data ?></td>
                                    <?php $count += 1 ?> <!-- adds to match count -->
                                <?php else : ?>                                 
                                    <td><?php echo $data ?></td> <!-- returns non matched data to complete field row -->
                                <?php endif ?>
                            
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        <?php endif ?>
        <div class="matches">
            <?php if ($count > 0) : ?>
                <p><?php echo "Number of matches: " . $count; ?></p> <!-- prints out number of matches found -->
            <?php else : ?>
                <p><?php echo "Number of matches: 0"; ?> <!-- default if no matches present -->
            <?php endif ?>
        </div>
    </div>   
</body>
</html>

