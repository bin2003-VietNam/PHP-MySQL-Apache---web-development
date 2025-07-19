<?php 
    $db = mysqli_connect("localhost","edna","ednapass","moviesite")
            or die("". mysqli_connect_error());
    $query = '
            CREATE TABLE images (
            image_id       INTEGER      NOT NULL AUTO_INCREMENT,
            image_caption  VARCHAR(255) NOT NULL,
            image_username VARCHAR(255) NOT NULL,
            image_filename VARCHAR(255) NOT NULL DEFAULT "",
            image_date     DATE         NOT NULL,
            PRIMARY KEY (image_id)
        ) ENGINE=MyISAM;
      ';
    $result = mysqli_query($db, $query);
    if ($result) {
        echo "success";
    } else {
        echo "failed: " . mysqli_error($db);
    }
?>