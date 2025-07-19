<?php 
    $db = mysqli_connect("localhost","edna","ednapass","moviesite")
            or die("". mysqli_connect_error());
    $query = '
          ALTER TABLE images DROP COLUMN image_filename    
    ';
    $result = mysqli_query($db, $query);
    if ($result) {
        echo "success";
    } else {
        echo "failed: " . mysqli_error($db);
    }
?>