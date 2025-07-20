<?php
$db = mysqli_connect(
    "localhost",
    "edna",
    "ednapass",
    "moviesite"
);
echo isset($_POST['action']) ? "true" : "false" ;
?>


<?php
switch ($_POST['action']) {
    case 'add':
        switch ($_GET['type']) {
            case 'movie':
                $error = array();

                $movie_name = isset($_POST['movie_name']) ? trim($_POST['movie_name']) : '';
                if (empty($movie_name)) {
                    $error[] = urlencode('Please enter a movie name.');
                }

                $movie_type = isset($_POST['movie_type']) ? trim($_POST['movie_type']) : '';
                if (empty($movie_type)) {
                    $error[] = urlencode('Please select a movie type.');
                }

                $movie_year = isset($_POST['movie_year']) ? trim($_POST['movie_year']) : '';
                if (empty($movie_year)) {
                    $error[] = urlencode('Please select a movie year.');
                }

                $movie_leadactor = isset($_POST['movie_leadactor']) ? trim($_POST['movie_leadactor']) : '';
                if (empty($movie_leadactor)) {
                    $error[] = urlencode('Please select a lead actor.');
                }

                $movie_director = isset($_POST['movie_director']) ? trim($_POST['movie_director']) : '';
                if (empty($movie_director)) {
                    $error[] = urlencode('Please select a director.');
                }

                if (empty($error)) {
                    $query = "INSERT INTO movie
                        (movie_name, movie_year, movie_type, movie_leadactor, movie_director)
                        VALUES (
                            '" . addslashes($movie_name) . "',
                            " . intval($movie_year) . ",
                            " . intval($movie_type) . ",
                            " . intval($movie_leadactor) . ",
                            " . intval($movie_director) . "
                        )";
                    // Thực thi query ở đây
                } else {
                    header('Location: movie.php?action=add&error=' . implode(urlencode('<br/>'), $error));
                    exit();
                }
                break;
        }
        break;
    case 'edit':
        switch ($_GET['type']) {
            case 'movie':
            $error = array();

            $movie_name = isset($_POST['movie_name']) ? trim($_POST['movie_name']) : '';
            if (empty($movie_name)) {
                $error[] = urlencode('Please enter a movie name.');
            }

            $movie_type = isset($_POST['movie_type']) ? trim($_POST['movie_type']) : '';
            if (empty($movie_type)) {
                $error[] = urlencode('Please select a movie type.');
            }

            $movie_year = isset($_POST['movie_year']) ? trim($_POST['movie_year']) : '';
            if (empty($movie_year)) {
                $error[] = urlencode('Please select a movie year.');
            }

            $movie_leadactor = isset($_POST['movie_leadactor']) ? trim($_POST['movie_leadactor']) : '';
            if (empty($movie_leadactor)) {
                $error[] = urlencode('Please select a lead actor.');
            }

            $movie_director = isset($_POST['movie_director']) ? trim($_POST['movie_director']) : '';
            if (empty($movie_director)) {
                $error[] = urlencode('Please select a director.');
            }

            if (empty($error)) {
                $query = "UPDATE movie
                    SET 
                        movie_name = '" . addslashes($movie_name) . "',
                        movie_year = " . intval($movie_year) . ",
                        movie_type = " . intval($movie_type) . ",
                        movie_leadactor = " . intval($movie_leadactor) . ",
                        movie_director = " . intval($movie_director) . "
                    WHERE
                        movie_id = " . intval($_POST['movie_id']);
                
                // Thực thi query tại đây, ví dụ: mysqli_query($conn, $query);
            } else {
                header('Location: movie.php?action=edit&id=' . intval($_POST['movie_id']) .
                    '&error=' . implode(urlencode('<br/>'), $error));
                exit();
            }
                break;
        }
        break;
}

if (isset($query)) {
    $result = mysqli_query( $db, $query) or die(mysqli_error($db));
}
?>
<html>
<head>
    <title>Commit</title>
</head>
<body>
<p>Done!</p>
<?php 
    echo "<br/><a href=\" admin.php\">Return to admin page</a>";
?>
</body>
</html>
