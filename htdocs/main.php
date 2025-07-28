<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged In</title>
</head>
<body>
    <h1>Welcome to the home page!</h1>

<?php
if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
?>
    <p>Thank you for logging into our system, <b><?php echo $_SESSION['username']; ?></b>.</p>
    <p>You may now <a href="user_personal.php">click here</a> to go to your
    own personal information area and update or remove your information should
    you wish to do so.</p>
<?php
    if ($_SESSION['admin_level'] > 0) {
        echo '<p><a href="admin_area.php">Click here</a> to access your administrator tools.</p>';
    }
} else {
?>
    <p>You are currently not logged in to our system. Once you log in,
    you will have access to your personal area along with other user
    information.</p>
    <p>If you have already registered, <a href="login.php">click here</a> to log in.
    Or if you would like to create an account, <a href="register.php">click here</a> to register.</p>
<?php
}
?>
</body>
</html>
