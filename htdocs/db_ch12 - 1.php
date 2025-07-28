<?php
require 'db.inc.php';

// Kết nối đến MySQL
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
if (!$db) {
    die('Unable to connect. Check your connection parameters: ' . mysqli_connect_error());
}

// Tạo bảng người dùng
$query = "CREATE TABLE IF NOT EXISTS site_user (
    user_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password CHAR(41) NOT NULL,
    PRIMARY KEY (user_id)
) ENGINE=MyISAM";
mysqli_query($db, $query) or die(mysqli_error($db));

// Tạo bảng thông tin người dùng
$query = "CREATE TABLE IF NOT EXISTS site_user_info (
    user_id INT NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    city VARCHAR(20),
    state CHAR(2),
    hobbies VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES site_user(user_id)
) ENGINE=MyISAM";
mysqli_query($db, $query) or die(mysqli_error($db));

// Chèn dữ liệu vào bảng người dùng
$password1 = password_hash('secret', PASSWORD_DEFAULT);
$password2 = password_hash('password', PASSWORD_DEFAULT);

$query = "INSERT IGNORE INTO site_user (user_id, username, password) VALUES
    (1, 'john', '$password1'),
    (2, 'sally', '$password2')";
mysqli_query($db, $query) or die(mysqli_error($db));


// Chèn dữ liệu vào bảng thông tin người dùng
$query = "INSERT IGNORE INTO site_user_info (user_id, first_name, last_name, email, city, state, hobbies) VALUES
    (1, 'John', 'Doe', 'jdoe@example.com', NULL, NULL, NULL),
    (2, 'Sally', 'Smith', 'ssmith@example.com', NULL, NULL, NULL)";
mysqli_query($db, $query) or die(mysqli_error($db));

echo 'Success!';
?>
