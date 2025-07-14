<?php 
    // connect to MySQL
    $servername = "localhost";
    $username = "edna";
    $password = "ednapass";
    $dbname = "moviesite";

    //Create connection
    $conn = mysqli_connect($servername, $username, $password);

    //Check connection
    if($conn-> connect_error){
        die("connection failed". $conn->connect_error);
    }

    echo "Connected successfully";

    $sql = "CREATE DATABASE IF NOT EXISTS moviesite" ;
    if(mysqli_query($conn, $sql)){
        echo "Database created successfully ";
        echo "<br/>";
    }else{
        echo "Error creating databvase" . mysqli_error( $conn);
    }

    $conn->select_db($dbname);

    // CREATE TABLE movie
    $sql = 'CREATE TABLE IF NOT EXISTS movie (
            movie_id    INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            movie_name  VARCHAR(255) NOT NULL,
            movie_type  TINYINT NOT NULL DEFAULT 0,
            movie_year  SMALLINT UNSIGNED NOT NULL DEFAULT 0,
            movie_leadactor INTEGER UNSIGNED NOT NULL DEFAULT 0,
            movie_director INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (movie_id),
            KEY movie_type (movie_type, movie_year)
            )
            ENGINE=MyISAM';
    if(mysqli_query($conn, $sql)){
        echo '<br/>';
        echo'Table movie created successfully';
    }else{
        echo '<br/>';
        die('Error creating table movie: ' . mysqli_error($conn));
    }

    // CREATE TABLE movietype
     $sql = 'CREATE TABLE IF NOT EXISTS movietype (
            movietype_id    TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
            movietype_label VARCHAR(100) NOT NULL,
            PRIMARY KEY (movietype_id)
            )
            ENGINE=MyISAM';
    if(mysqli_query($conn, $sql)){
        echo '<br/>';
        echo'Table movieType created successfully';
    }else{
        echo '<br/>';
        die('Error creating table movietype: ' . mysqli_error($conn));
    }

    // CREATE TABLE people
    $sql = 'CREATE TABLE IF NOT EXISTS people ( 
            people_id         INTEGER UNSIGNED    NOT NULL AUTO_INCREMENT, 
            people_fullname   VARCHAR(255)        NOT NULL, 
            people_isactor    TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, 
            people_isdirector TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, 
                        
            PRIMARY KEY (people_id)
        ) 
        ENGINE=MyISAM';
    if(mysqli_query($conn, $sql)){
        echo '<br/>';
        echo'Table people created successfully';
    }else{
        echo '<br/>';
        die('Error creating table people: ' . mysqli_error($conn));
    }

    mysqli_close($conn);
   
?>