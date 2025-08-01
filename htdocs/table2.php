<?php
    // take in the id of a director and return his/her full name
    function get_director($director_id) {
    global $db;

    $query = 'SELECT people_fullname 
              FROM people 
              WHERE people_id = ' . intval($director_id);

    $result = mysqli_query( $db,$query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $people_fullname;
    }

    // take in the id of a lead actor and return his/her full name
    function get_leadactor($leadactor_id) {
        global $db;

        $query = 'SELECT people_fullname 
                FROM people 
                WHERE people_id = ' . intval($leadactor_id);

        $result = mysqli_query( $db,$query) or die(mysqli_error($db));

        $row = mysqli_fetch_assoc($result);
        extract($row);

        return $people_fullname;
    }

    // take in the id of a movie type and return the meaningful textual description
    function get_movietype($type_id) {
        global $db;

        $query = 'SELECT movietype_label 
                FROM movietype 
                WHERE movietype_id = ' . intval($type_id);

        $result = mysqli_query( $db,$query) or die(mysqli_error($db));

        $row = mysqli_fetch_assoc($result);
        extract($row);

        return $movietype_label;
    }

    // connect to MySQL
    $servername = "localhost";
    $username = "edna";
    $password = "ednapass";
    $dbname = "moviesite";

    //Create connection
    $db = new mysqli($servername, $username, $password, $dbname);

    //Check connection
    if($db-> connect_error){
        die("connection failed". $db->connect_error);
    }

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
    $result = mysqli_query($db, $sql);
    $num_movies = mysqli_num_rows($result);
?>


<?php 
    $table = <<<ENDHTML
    <div style="text-align: center;"> 
        <h2>Movie Review Database</h2> 
        <table border="1" cellpadding="2" cellspacing="2"
        style="width: 70%; margin-left: auto; margin-right: auto;"> 
            <tr> 
                <th>Movie Title</th> 
                <th>Year of Release</th> 
                <th>Movie Director</th> 
                <th>Movie Lead Actor</th> 
                <th>Movie Type</th> 
            </tr> 
    ENDHTML;

    foreach($result as $row){
                extract($row);
                $director = get_director($movie_director);
                $leadactor = get_leadactor($movie_leadactor);
                $movietype = get_movietype($movie_type);

                $table .= <<<ENDHTML
                <tr> 
                    <td>$movie_name</td> 
                    <td>$movie_year</td> 
                    <td>$director</td> 
                    <td>$leadactor</td> 
                    <td>$movietype</td> 
                </tr> 
                ENDHTML;
            }

    $table .= <<<ENDHTML
    </table>
      <p>$num_movies Movies</p>
    </div>
    ENDHTML;

    echo $table; 

?>