<?php 
require 'db.inc.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
        or die('Unable to connect. Check your connection parameters');
$query = "CREATE TABLE IF NOT EXISTS comic_character(
            character_id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
            alias         VARCHAR(40)  NOT NULL DEFAULT '',
            real_name     VARCHAR(80)  NOT NULL DEFAULT '',
            lair_id       INT UNSIGNED NOT NULL DEFAULT 0,
            alignment     ENUM('good', 'evil') NOT NULL DEFAULT 'good',

            PRIMARY KEY (character_id)
        ) ENGINE=MyISAM";        
mysqli_query($db, $query) or die (mysqli_error($db));

// create the comic_power table
$query = 'CREATE TABLE IF NOT EXISTS comic_power (
    power_id  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    power     VARCHAR(40)      NOT NULL DEFAULT "",

    PRIMARY KEY (power_id)
) ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));

// create the comic_character_power linking table
$query = 'CREATE TABLE IF NOT EXISTS comic_character_power(
            character_id INTEGER UNSIGNED NOT NULL DEFAULT 0,
            power_id     INTEGER UNSIGNED NOT NULL DEFAULT 0,

            PRIMARY KEY (character_id, power_id)
        ) ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));   

// create the comic_lair table
$query = 'CREATE TABLE IF NOT EXISTS comic_lair (
            lair_id     INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
            zipcode_id  CHAR(5)          NOT NULL DEFAULT "00000",
            address     VARCHAR(40)      NOT NULL DEFAULT "",

            PRIMARY KEY (lair_id)
        ) ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));

// create the comic_zipcode table
$query = 'CREATE TABLE IF NOT EXISTS comic_zipcode (
    zipcode_id  CHAR(5)     NOT NULL DEFAULT "00000",
    city        VARCHAR(40) NOT NULL DEFAULT "",
    state       CHAR(2)     NOT NULL DEFAULT "",

    PRIMARY KEY (zipcode_id)
) ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));

// create the comic_rivalry table
$query = 'CREATE TABLE IF NOT EXISTS comic_rivalry (
    hero_id     INTEGER UNSIGNED  NOT NULL DEFAULT 0,
    villain_id  INTEGER UNSIGNED  NOT NULL DEFAULT 0,

    PRIMARY KEY (hero_id, villain_id)
) ENGINE=MyISAM';
mysqli_query($db, $query) or die (mysqli_error($db));

echo 'Done.';

?>