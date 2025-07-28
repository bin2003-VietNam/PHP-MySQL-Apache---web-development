<?php
session_start();
include 'db.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or 
    die('Unable to connect. Check your connection parameters.');


// filter incoming values
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : 'main.php';

if (isset($_POST['submit'])) {
    $query = "SELECT admin_level FROM site_user WHERE " .
        "username = '" . mysqli_real_escape_string($db,$username) . "' AND " .
        "password = '" . mysqli_real_escape_string($db,$password) . "'";
    
    $result = mysqli_query($db,$query ) or die(mysqli_error($db));
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['logged'] = 1;
        $_SESSION['admin_level'] = $row['admin_level'];
        
        header("Refresh: 5; URL=$redirect");
        echo '<p>You will be redirected to your original page request.</p>';
        echo "<p>If your browser doesn’t redirect you automatically, 
        <a href=\"$redirect\">click here</a>.</p>";
        
        mysqli_free_result($result);
        mysqli_close($db);
        die();
    } else {
        $_SESSION['username'] = '';
        $_SESSION['logged'] = 0;
        $_SESSION['admin_level'] = 0;
        $error = '<p><strong>You have supplied an invalid username and/or password!</strong> 
        Please <a href="register.php">click here to register</a> if you have not done so already.</p>';
    }

    mysqli_free_result($result);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php
if (isset($error)) {
    echo $error;
}
?>
<form action="login.php" method="post">
    <table>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username" maxlength="20" size="20"
                       value="<?php echo htmlspecialchars($username); ?>" /></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" maxlength="20" size="20"
                       value="<?php echo htmlspecialchars($password); ?>" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>" />
                <input type="submit" name="submit" value="Login" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<?php
mysqli_close($db);
?>
