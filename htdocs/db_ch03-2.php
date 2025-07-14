<?php 
    // connect to MySQL
    $servername = "localhost";
    $username = "edna";
    $password = "ednapass";
    $dbname = "moviesite";

    //Create connection
    $conn = new mysqli($servername, $username, $password);

    //Check connection
    if($conn-> connect_error){
        die("connection failed". $conn->connect_error);
    }
    echo "Connected successfully";  echo"<br/>";

   // select moviesite db
   mysqli_select_db($conn, $dbname);

   // insert data into movie table
    $query = '
        INSERT INTO movie
        (movie_id,
        movie_name,
        movie_type,
        movie_year, 
        movie_leadactor, 
        movie_director)
        VALUES 
            (1, "Bruce Almighty", 5, 2003, 1, 2),
            (2, "Office  Space", 5, 1999, 5, 6),
            (3, "Grand Canyon", 2, 1991, 4, 3)';
    if(mysqli_query($conn, $query)){
        echo 'New record created success fully in movie table'; echo'<br/>';
    }else{
        echo 'Error: ' . mysqli_error( $conn);
    }

    // insert data into movietype
    $query = '
        INSERT INTO movietype
        (movietype_id, movietype_label)
        VALUES
            (1, "Sci Fi"),
            (2, "Drama"),
            (3, "Adventure"),
            (4, "War"),
            (5, "Comedy"),
            (6, "Horror"),
            (7, "Action"),
            (8, "Kids")
    ';
    if(mysqli_query($conn, $query)){
        echo 'New record created success fully in movietype table'; echo'<br/>';
    }else{
        echo 'Error: ' . mysqli_error( $conn);
    }

    // insert data into people
    $query  = 'INSERT INTO people
        (people_id, people_fullname, people_isactor, people_isdirector)
    VALUES
        (1, "Jim Carrey", 1, 0),
        (2, "Tom Shadyac", 0, 1),
        (3, "Lawrence Kasdan", 0, 1),
        (4, "Kevin Kline", 1, 0),
        (5, "Ron Livingston", 1, 0),
        (6, "Mike Judge", 0, 1)';
    if(mysqli_query($conn, $query)){
        echo 'New record created success fully in people table'; echo'<br/>';
    }else{
        echo 'Error: ' . mysqli_error( $conn);
    }

?>