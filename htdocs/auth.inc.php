<?php
// start or continue session
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
    header('Refresh: 5; URL=login.php?redirect=' . $_SERVER['PHP_SELF']);
    echo '<p>You will be redirected to the login page in 5 seconds.</p>';
    echo '<p>If your browser doesn\'t redirect you automatically, 
            <a href="login.php?redirect=' . $_SERVER['PHP_SELF'] . '">click here</a>.</p>';
    die();
}
?>
