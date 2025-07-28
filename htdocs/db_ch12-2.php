<?php
include 'db.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or 
    die('Unable to connect. Check your connection parameters.');

// update the user table
$query = "ALTER TABLE site_user
    ADD COLUMN admin_level TINYINT UNSIGNED NOT NULL DEFAULT 0 
    AFTER password";
mysqli_query($db,$query ) or die(mysqli_error($db));

// give one of our test accounts administrative privileges
$query = "UPDATE site_user SET admin_level = 1 WHERE username = 'john'";
mysqli_query($db,$query ) or die(mysqli_error($db));

echo 'Success!';
?>
