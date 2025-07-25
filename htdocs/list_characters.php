<!DOCTYPE html>
<html>
<head>
    <title>Character Database</title>
    <style type="text/css">
        th {
            background-color: #999;
        }
        td {
            vertical-align: top;
        }
        .odd_row {
            background-color: #EEE;
        }
        .even_row {
            background-color: #FFF;
        }
    </style>
</head>
<body>
    <img src="./images/2.jpg" alt="Comic Book Appreciation Site" style="float: left; width: 200px; height: 200px;" />
    <h1>Comic Book<br/>Appreciation</h1>
    <h2>Character Database</h2>
    <hr style="clear: both;" />
    
    <?php
    require 'db.inc.php';
    
    $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die('Unable to connect. Check your connection parameters.');
    
    // determine sorting order of table
    $order = array(
        1 => 'alias ASC',
        2 => 'real_name ASC',
        3 => 'alignment ASC, alias ASC'
    );
    
    $o = (isset($_GET['o']) && ctype_digit($_GET['o'])) ? $_GET['o'] : 1;
    if (!in_array($o, array_keys($order))) {
        $o = 1;
    }
    
    // select list of characters for table
    $query = 'SELECT character_id, alias, real_name, alignment FROM comic_character ORDER BY ' . $order[$o];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th><a href="' . $_SERVER['PHP_SELF'] . '?o=1">Alias</a></th>';
        echo '<th><a href="' . $_SERVER['PHP_SELF'] . '?o=2">Real Name</a></th>';
        echo '<th><a href="' . $_SERVER['PHP_SELF'] . '?o=3">Alignment</a></th>';
        echo '<th>Powers</th>';
        echo '<th>Enemies</th>';
        echo '</tr>';
        
        $odd = true; // alternate odd/even row styling
        
        while ($row = mysqli_fetch_array($result)) {
            echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
            $odd = !$odd;
            
            echo '<td><a href="edit_character.php?id=' . $row['character_id'] . '">' . $row['alias'] . '</a></td>';
            echo '<td>' . $row['real_name'] . '</td>';
            echo '<td>' . $row['alignment'] . '</td>';
            
            // select list of powers for this character
            $query2 = 'SELECT power FROM comic_power p JOIN comic_character_power cp ON p.power_id = cp.power_id WHERE cp.character_id = ' . $row['character_id'] . ' ORDER BY power ASC';
            $result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
            
            if (mysqli_num_rows($result2) > 0) {
                $powers = array();
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $powers[] = $row2['power'];
                }
                echo '<td>' . implode(', ', $powers) . '</td>';
            } else {
                echo '<td>none</td>';
            }
            mysqli_free_result($result2);
            
            // select list of rivalries for this character
            $query2 = 'SELECT c2.alias FROM comic_character c1 
                      JOIN comic_character c2 
                      JOIN comic_rivalry r ON (c1.character_id = r.hero_id AND c2.character_id = r.villain_id) 
                                           OR (c2.character_id = r.hero_id AND c1.character_id = r.villain_id) 
                      WHERE c1.character_id = ' . $row['character_id'] . ' 
                      ORDER BY c2.alias ASC';
            $result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
            
            if (mysqli_num_rows($result2) > 0) {
                $aliases = array();
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $aliases[] = $row2['alias'];
                }
                echo '<td>' . implode(', ', $aliases) . '</td>';
            } else {
                echo '<td>none</td>';
            }
            mysqli_free_result($result2);
            
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p><strong>No Characters entered...</strong></p>';
    }
    ?>
    
    <p><a href="edit_character.php">Add New Character</a></p>
    <p><a href="edit_power.php">Edit Powers</a></p>
</body>
</html>