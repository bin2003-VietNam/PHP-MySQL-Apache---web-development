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

    // select the movie titles and their genre after 1990
    $query = "
        SELECT 
            movie_name, movietype.movietype_label
        FROM 
            movie, movietype
        WHERE
            movie.movie_type = movietype.movietype_id AND movie_year > 1990
        ORDER BY 
            movie_type;
    ";
    $result = mysqli_query($conn, $query);
    foreach($result as $row){
        echo "<br/>";
        extract($row);
        echo $movie_name . ' - ' . $movietype_label;

    }


?>