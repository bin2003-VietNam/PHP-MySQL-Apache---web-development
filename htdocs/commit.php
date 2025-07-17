<?php
$db = mysqli_connect(
    "localhost",
    "edna",
    "ednapass",
    "moviesite"
);
?>

<html>
<head>
    <title>Commit</title>
</head>
<body>
<?php
switch ($_GET['action']) {
    case 'add':
        switch ($_GET['type']) {
            case 'movie':
                $query = 'INSERT INTO movie
                    (movie_name, movie_year, movie_type, movie_leadactor, movie_director)
                    VALUES (
                        "' . $_POST['movie_name'] . '",
                        ' . $_POST['movie_year'] . ',
                        ' . $_POST['movie_type'] . ',
                        ' . $_POST['movie_leadactor'] . ',
                        ' . $_POST['movie_director'] . '
                    )';
                break;
        }
        break;
    case 'edit':
        switch ($_GET['type']) {
            case 'movie':
                $query = 'UPDATE movie SET
                                movie_name = "' . $_POST['movie_name'] . '",
                                movie_year = ' . $_POST['movie_year'] . ',
                                movie_type = ' . $_POST['movie_type'] . ',
                                movie_leadactor = ' . $_POST['movie_leadactor'] . ',
                                movie_director = ' . $_POST['movie_director'] . '
                            WHERE movie_id = ' . $_POST['movie_id'];
                break;
        }
        break;
}

if (isset($query)) {
    $result = mysqli_query( $db, $query) or die(mysqli_error($db));
}
?>
<p>Done!</p>
<?php 
    echo "<br/><a href=\" admin.php\">Return to admin page</a>";
?>
</body>
</html>
