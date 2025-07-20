<?php 
    $db = mysqli_connect("localhost","edna","ednapass","moviesite")
            or die("". mysqli_connect_error());
    $query = '
          ALTER TABLE movie ADD COLUMN (    
                movie_release INTEGER UNSIGNED DEFAULT 0,
                movie_rating TINYINT UNSIGNED DEFAULT 5
          )';
    $result = mysqli_query($db, $query);
    if ($result) {
        echo "Movie database successfully updated !";
    } else {
        echo "failed: " . mysqli_error($db);
    }
?>