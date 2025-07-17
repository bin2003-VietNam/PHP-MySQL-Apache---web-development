<?php
$db = mysqli_connect(
    "localhost",
    "edna",
    "ednapass",
    "moviesite"
);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Movie database</title>
        <style type="text/css">
            th { background-color: #999; }
            .odd_row { background-color: #EEE; }
            .even_row { background-color: #FFF; }
        </style>
    </head>
    <body>
        <table style="width:100%;">
            <!-- MOVIES -->
            <tr>
                <th colspan="2">Movies <a href="movie.php?action=add&type=movie">[ADD]</a></th>
            </tr>
            <?php 
                $query = "SELECT * FROM movie;";
                $result = mysqli_query($db, $query);
                $odd = true;
                
                while ($row = mysqli_fetch_array($result)){
                    echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
                    $odd = !$odd;
                    echo '<td style = width:75%>';
                    echo $row['movie_name'];
                    echo '</td><td>';
                    echo '<a href="movie.php?action=edit&id=' . $row['movie_id'] . '">'
                    . ' [EDIT] </a>';
                    echo '<a href="movie.php?action=delete&id=' . $row['movie_id'] . '">'
                    . ' [DELETE] </a>';
                    echo '</td></tr>';
                }
            ?>
            <!-- People -->
            <tr>
                <th colspan="2">People <a href="people.php?action=add&type=people">[ADD]</a></th>
            </tr>
            <?php 
                $query = 'SELECT * FROM people';
                $result = mysqli_query($db, $query);
                $odd = true;

                while ($row = mysqli_fetch_array($result)) {
                    echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
                    $odd = !$odd; 
                    echo '<td style="width: 25%;">'; 
                    echo $row['people_fullname'];
                    echo '</td><td>';
                    echo '<a href="people.php?action=edit&id=' . $row['people_id'] . '">[DELETE]</a>';
                    echo '</td></tr>';
                }

            ?>
        </table>
    </body>
</html>