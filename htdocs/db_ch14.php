<?php 
    require 'db.inc.php';
    $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
    or die (mysqli_error($db));

    // CREATE table ml_lists
    $sql = 'CREATE TABLE IF NOT EXISTS ml_lists(
            ml_id       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            listname    VARCHAR(100)     NOT NULL,

            PRIMARY KEY (ml_id)
    )ENGINE=MyISAM';
    mysqli_query($db, $sql) or die (mysqli_error($db));

    //CREATE TABLE ml_users
    $sql = 'CREATE TABLE IF NOT EXISTS ml_users(
            user_id     INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            first_name  VARCHAR(20) NOT NULL,
            last_name   VARCHAR(20) NOT NULL,
            Email       VARCHAR(100) NOT NULL,

            PRIMARY KEY (user_id)
    )ENGINE=MyISAM';
    mysqli_query($db, $sql) or die (mysqli_error($db));

    // CREATE TABLE ml_subscriptions
    $sql = 'CREATE TABLE IF NOT EXISTS ml_subscriptions(
            ml_id   INTEGER UNSIGNED NOT NULL,
            user_id INTEGER UNSIGNED NOT NULL,
            pending BOOLEAN          NOT NULL,

            PRIMARY KEY (ml_id, user_id)
    )ENGINE=MyISAM';
    mysqli_query($db, $sql) or die (mysqli_error($db));

    echo'Sucess';

?>