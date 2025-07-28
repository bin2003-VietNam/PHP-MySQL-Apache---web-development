<?php
// Expire the cookies by setting a past timestamp
$expire = time() - 1000;

setcookie('username', '', $expire);
setcookie('remember_me', '', $expire);

// Redirect to another page after 5 seconds
header('Refresh: 5; URL=cookies_test.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cookies Test (Delete)</title>
</head>
<body>
    <h1>Deleting Cookies</h1>
    <p>You will be redirected to the main test page in 5 seconds.</p>
    <p>If your browser doesn’t redirect you automatically,
       <a href="cookies_test.php">click here</a>.
    </p>
</body>
</html>