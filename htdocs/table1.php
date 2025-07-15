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

    // select moviesite db
    mysqli_select_db($conn, $dbname);

    // Retrieve information
    $sql = "SELECT
                movie_name, 
                movie_year, 
                movie_director, 
                movie_leadactor,
                movie_type
            FROM
                movie
            ORDER BY 
                movie_name ASC,
                movie_year DESC";
    $result = mysqli_query($conn, $sql);
    $num_movies = mysqli_num_rows($result);
?>

<div style="text-align: center;">
    <h2>Movie Review Database</h2>
    <table border="1" cellpadding="2" cellspacing="2"
        style="width: 70%; margin-left:auto; margin-right: auto;">
        <tr>
            <th>Movie Title</th>
            <th>Year of release</th>
            <th>Movie Director</th>
            <th>Movie Lead Actor</th>
            <th>Movie Type</th>
        </tr>
        <?php 
            foreach($result as $row){
                extract($row);
                echo "<tr>";
                    echo "<td>" . $movie_name . "</td>";
                    echo "<td>" . $movie_year . "</td>";
                    echo "<td>" . $movie_director . "</td>";
                    echo "<td>" . $movie_leadactor . "</td>";
                    echo "<td>" . $movie_type . "</td>";
                echo"</tr>";
            }
        ?>
    </table>
</div>