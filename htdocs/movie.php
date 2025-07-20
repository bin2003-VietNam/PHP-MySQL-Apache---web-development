<?php
echo isset($_GET['action']) ? $_GET['action'] : "false" ;
$db = mysqli_connect(
    "localhost",
    "edna",
    "ednapass",
    "moviesite"
);
if($_GET["action"] == "delete"){
    header("Location: delete.php?id=" . $_GET['id']);
    exit();
}
// tiền xử form nếu action = edit
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "
        SELECT 
            movie_name, movie_year, movie_type, movie_leadactor, movie_director
        FROM 
            movie
        WHERE
            movie_id=" . $id;
    $result = mysqli_query($db, $sql);
    $movieRow = mysqli_fetch_array($result);
    print_r($movieRow);
}

// kết thúc tiền xử lý form
?>

<html>
    <head>
        <title>Add movie</title>
        <style type="text/css">
            #error {
                background-color: #900;
                border: 1px solid #FF0;
                color: #FFF;
                text-align: center;
                margin: 10px;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        if (isset($_GET['error']) && $_GET['error'] != '') {
            echo '<div id="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
        <form action="commit.php?&type=movie" method="post">
            <input type="hidden" name="action" value="<?php echo $_GET['action'];?>"/>
            <table>
                <tr>
                    <td>Movie Name</td>
                    <td>
                        <input type="text" name="movie_name" value="<?php echo isset($movieRow['movie_name']) ? $movieRow['movie_name'] : ''; ?>"/>
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
                                    $selected = ($row["movietype_id"] == $movieRow["movie_type"]) ? "selected" : "";
                                    echo '<option value="' . $row['movietype_id'] . '"' . $selected . '>';
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
                                    $selected = ($yr == $movieRow["movie_year"]) ? "selected" : "";
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
                                $selected = ($row["people_id"] == $movieRow["movie_leadactor"]) ? "selected" : "";
                                echo '<option value="' . $row['people_id'] . '"' . $selected . '>';
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
                                $selected = ($row["people_id"] == $movieRow["movie_director"]) ? "selected" : "";
                                echo '<option value="' . $row['people_id'] . '"' . $selected . '>';
                                echo $row['people_fullname'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Edit"/>
                    </td>
                </tr>
            </table>
        </form>
       
    </body>
</html>