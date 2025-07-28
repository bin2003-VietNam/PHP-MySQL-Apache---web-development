<?php 
    // cookies may expire 30 days from now (given in seconds)
    $expire  = time() + (60*60*24*30);

    setcookie('username', 'test_user', $expire);
    setcookie('remember_me', 'yes', $expire);

    header('Refresh: 5, URL=cookies_test.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COOKIES TEST (SET)</title>
</head>
<body>
    <h1>Setting Cookies</h1>
    <p>You will be redirected to main test page in 5 seconds</p>
    <p>If your browser doesn't redirect you automatically,</p>
    <a href="cookies_test.php">Click me</a>
</body>
</html>