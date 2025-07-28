<?php
include 'auth.inc.php';

if ($_SESSION['admin_level'] < 1) {
    header('Refresh: 5; URL=user_personal.php');
    echo '<p><strong>You are not authorized for this page.</strong></p>';
    echo '<p>You are now being redirected to the main page. 
    If your browser doesn’t redirect you automatically, 
    <a href="main.php">click here</a>.</p>';
    die();
}

include 'db.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or 
    die('Unable to connect. Check your connection parameters.');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administration Area</title>
    <style type="text/css">
        th { background-color: #999; }
        .odd_row { background-color: #EEE; }
        .even_row { background-color: #FFF; }
    </style>
</head>
<body>
    <h1>Welcome to the Administration area.</h1>
    <p>Here you can view and manage other users.</p>
    <p><a href="main.php">Click here</a> to return to the home page.</p>
    <table style="width:70%" border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
<?php
$query = "
    SELECT
        u.user_id, username, first_name, last_name
    FROM
        site_user u
        JOIN site_user_info i ON u.user_id = i.user_id
    ORDER BY
        username ASC";
$result = mysqli_query($db,$query ) or die(mysqli_error($db));

$odd = true;
while ($row = mysqli_fetch_array($result)) {
    echo ($odd) ? '<tr class="odd_row">' : '<tr class="even_row">';
    $odd = !$odd;
    echo '<td><a href="update_user.php?id=' . $row['user_id'] . '">' . htmlspecialchars($row['username']) . '</a></td>';
    echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
    echo '</tr>';
}
mysqli_free_result($result);
mysqli_close($db);
?>
    </table>
</body>
</html>
