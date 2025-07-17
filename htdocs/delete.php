<?php
    $db = mysqli_connect(
        "localhost",
        "edna",
        "ednapass",
        "moviesite"
    );

    $id = $_GET['id'];
    $sql = "
        DELETE 
        FROM 
            movie
        WHERE 
            movie_id =" . $id ;

    if ($result = mysqli_query($db, $sql)) {
        $affected_rows = mysqli_affected_rows($db);
        echo "Deleted successfully. Rows affected: $affected_rows";
        echo "<br/><a href=\" admin.php\">Return to admin page</a>";
    } else {
        echo "Error: " . mysqli_error($db);
    }

    mysqli_close($db);

?>