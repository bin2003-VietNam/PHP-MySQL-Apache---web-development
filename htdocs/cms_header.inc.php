<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CMS</title>
  <style type="text/css">
    td { vertical-align: top; }
  </style>
</head>
    <body>
    <h1>Comic Book Appreciation</h1>

    <?php
    if (isset($_SESSION['name'])) {
        echo '<p>You are currently logged in as: ' . htmlspecialchars($_SESSION['name']) . '</p>';
    }
    ?>

        <div id="navright">
            <form method="get" action="cms_search.php">
            <div>
                <label for="search">Search</label>
                <?php
                echo '<input type="text" id="search" name="search" ';
                if (isset($_GET['keywords'])) {
                    echo 'value="' . htmlspecialchars($_GET['keywords']) . '" ';
                }
                echo '/>';
                ?>
                <input type="submit" value="Search" />
            </div>
            </form>
        </div>

        <div id="navigation">
            <a href="cms_index.php">Articles</a>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo ' | <a href="cms_compose.php">Compose</a>';
                if ($_SESSION['access_level'] > 1) {
                    echo ' | <a href="cms_pending.php">Review</a>';
                }
                if ($_SESSION['access_level'] > 2) {
                    echo ' | <a href="cms_admin.php">Admin</a>';
                }
                echo ' | <a href="cms_cpanel.php">Control Panel</a>';
                echo ' | <a href="cms_transact_user.php?action=Logout">Logout</a>';
            } else {
                echo ' | <a href="cms_login.php">Login</a>';
            }
            ?>
        </div>

    <div id="articles">

