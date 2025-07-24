<!DOCTYPE html>
<html>
<head>
    <title>Edit Powers</title>
    <style type="text/css">
        td {
            vertical-align: top;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" alt="Comic Book Appreciation Site" style="float: left;" />
    <h1>Comic Book<br/>Appreciation</h1>
    <h2>Edit Character Powers</h2>
    <hr style="clear: both;" />
    
    <form action="char_transaction.php" method="post">
        <div>
            <input type="text" name="new_power" size="20" maxlength="40" value="" />
            <input type="submit" name="action" value="Add New Power" />
        </div>
        
        <?php
        require 'db.inc.php';
        
        $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die('Unable to connect. Check your connection parameters.');
        
        $query = 'SELECT power_id, power FROM comic_power ORDER BY power ASC';
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        
        if (mysqli_num_rows($result) > 0) {
            echo '<p><em>Deleting a power will remove its association with any ' .
                 'characters as well-- select wisely!</em></p>';
            
            $num_powers = mysqli_num_rows($result);
            $threshold = 5;
            $max_columns = 2;
            $num_columns = min($max_columns, ceil($num_powers / $threshold));
            $count_per_column = ceil($num_powers / $num_columns);
            $i = 0;
            
            echo '<table><tr><td>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                if (($i > 0) && ($i % $count_per_column == 0)) {
                    echo '</td><td>';
                }
                
                echo '<input type="checkbox" name="powers[]" value="' . $row['power_id'] . '" />';
                echo $row['power'] . '<br/>';
                $i++;
            }
            
            echo '</td></tr></table>';
            echo '<br/><input type="submit" name="action" value="Delete Selected Powers" />';
            
        } else {
            echo '<p><strong>No Powers entered...</strong></p>';
        }
        ?>
        
    </form>
    
    <p><a href="list_characters.php">Return to Home Page</a></p>
</body>
</html>