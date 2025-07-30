<?php 
    require 'db.inc.php';
    $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
    or die (mysqli_error($db));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailing List Administrator</title>
    <style type="text/css">
        td{
            vertical-align: top;
        }
    </style>
</head>
<body>
    <h1>Mailing List Administrator</h1>
    <form method="post" action="ml_admin_transact.php">
        <p><label for="listname">Add Mailing List:</label>
            <input type="text" id="listname" name="listname" maxlength="100"/>
            <input type="submit" name="action" value="Add New Mailing List"/>
        </p>
    
    <?php 
        $sql = 'SELECT
                    ml_id, listname
                FROM
                    ml_lists
                ORDER BY
                    listname ASC';
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
        if(mysqli_num_rows($result)>0){
            echo '<p><label for="ml_id">Delete Mailing List:</label><br/>';
            echo '<select name="ml_id" id="ml_id">';
            while($row = mysqli_fetch_array($result)){
                echo '<option value="' . $row['ml_id'] . '">' . $row['listname'] . '</option>';
            }
            echo '</select>';
            echo'<input type="submit" name="action" value="Delete Mailing List" />';
            echo'</p>';
        }
        mysqli_free_result($result);
    ?>
    </form>
    <p><a href="ml_quick_msg.php">Send a quick message to users.</a></p>
</body>
</html>
