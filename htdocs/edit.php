<?php
$db = mysqli_connect(
    "localhost",
    "edna",
    "ednapass",
    "moviesite"
);
$sql = "
    SELECT 
        movie_name, movie_year, movie_type, movie_leadactor, movie_director
    FROM 
        movie
    WHERE
        movie_id=" . $_GET['id'];
$result = mysqli_query($db, $sql);
$movieRow = mysqli_fetch_assoc($result);
?>

<html>
    <head>
        <title>Add movie</title>
    </head>
    <body>
        <form action="commit.php?action=edit&type=movie" method="post">
            <table>
                <tr>
                    <td>Movie Name</td>
                    <td>
                        <input type="text" name="movie_name" value=<?php echo $movieRow['movie_name'];?>/>
                    </td>
                </tr>
                <tr>
                    <td>Movie Type</td>
                    <td>
                        <select name="movie_type">
                            <?php 
                                $sql = "
                                    SELECT 
                                        movietype_id, movietype_label
                                    FROM
                                        movietype
                                    ORDER BY
                                        movietype_label
                                ";
                                $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                                while($row = mysqli_fetch_array($result)){
                                    $selected = ($movieRow['movie_type'] == $row['movietype_id']) ? 'selected' : '';
                                    echo '<option value="' . $row['movietype_id'] . '" ' . $selected . '>';
                                    echo $row['movietype_label'] . '</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Movie Year</td>
                    <td>
                        <select name="movie_year">
                            <?php 
                                for ($yr = date('Y'); $yr >= 1970 ; $yr--) {
                                    $selected = ($yr == $movieRow['movie_year']) ? 'selected' : '';
                                    echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Lead Actor</td>
                    <td>
                        <select name="movie_leadactor">
                            <?php 
                            $sql = '
                                SELECT
                                     people_id, people_fullname
                                FROM
                                    people
                                WHERE
                                    people_isactor = 1
                                ORDER BY
                                    people_fullname

                            ';
                            $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                            while($row = mysqli_fetch_array($result)){
                                $selected = ($row['movie_leadactor'] == $row[''])  ? 'selected' : '';
                                echo '<option value="' . $row['people_id'] . '"'. $selected .'>';
                                echo $row['people_fullname'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Director</td>
                    <td>
                        <select name="movie_director">
                            <?php 
                            $sql = '
                                SELECT
                                     people_id, people_fullname
                                FROM
                                    people
                                WHERE
                                    people_isdirector = 1
                                ORDER BY
                                    people_fullname

                            ';
                            $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                            while($row = mysqli_fetch_array($result)){
                                $selected = ($movieRow['movie_director'] == $row['movie_director'])  ? 'selected' : '';
                                echo '<option value="' . $row['people_id'] . '"' . $selected . '>';
                                echo $row['people_fullname'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Add"/>
                    </td>
                </tr>
            </table>
        </form>
       
    </body>
</html>