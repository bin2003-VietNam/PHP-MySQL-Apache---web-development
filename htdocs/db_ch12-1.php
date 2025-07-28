<?php 
    require 'db.inc.php';
    
    $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB )
    or die(mysqli_error($db));

    // CREATE site_user table
    $sql = 'CREATE TABLE IF NOT EXISTS site_user(
            user_id INTEGER NOT NULL AUTO_INCREMENT,
            username VARCHAR(200) NOT NULL,
            password CHAR(41)  NOT NULL,

            PRIMARY KEY (user_id)
    ) ENGINE=MyISAM';

    mysqli_query($db, $sql) or die(mysqli_error($db));

    // CREATE site_user_infor table
    $sql = ' CREATE TABLE IF NOT EXISTS site_user_infor(
            user_id     INTEGER NOT NULL,
            first_name  VARCHAR(200) NOT NULL,
            last_name   VARCHAR(200) NOT NULL,
            email       VARCHAR(200) NOT NULL,
            city        VARCHAR(200) ,
            state       CHAR(2),
            hobbies     VARCHAR(200),

            FOREIGN KEY (user_id) REFERENCES site_user(user_id)

    ) ENGINE=MyISAM';
    mysqli_query($db, $sql) or die(mysqli_error($db));

    // populate the user table
    $sql = ' INSERT IGNORE INTO site_user
            (username, password)
            VALUES
                ("john","123"),
                ("bin","321")';
    mysqli_query($db, $sql) or die(mysqli_error($db));

    echo 'success';


?>