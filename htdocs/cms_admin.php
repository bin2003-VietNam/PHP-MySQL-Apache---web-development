 <?php
 require 'db.inc.php';
 include 'cms_header.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');
                   
                   
$sql = 'SELECT
        access_level, access_name
    FROM
        cms_access_levels
    ORDER BY
        access_name ASC';
 $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                   
$privileges = array();
 while ($row = mysqli_fetch_assoc($result)) {
    $privileges[$row['access_level']] = $row['access_name'];
 }
 mysqli_free_result($result);
                   
echo ' <h2> User Administration </h2> ';
                   
$limit = count($privileges);
 for($i = 1; $i  <= $limit; $i++) {
    echo ' <h3> ' . $privileges[$i] . ' </h3> ';
    $sql = 'SELECT
            user_id, name
        FROM
            cms_users
        WHERE
            access_level = ' . $i . '
        ORDER BY
            name ASC';
    $result = mysqli_query($db,$sql) or die(mysqli_error($db));
                   
    if (mysqli_num_rows($result) == 0) {
        echo ' <p>  <strong> There are no ' . $privileges[$i] . ' accounts ' .
            'registered. </strong>  </p> ';
    } else {
        echo ' <ul> ';
        while ($row = mysqli_fetch_assoc($result)) {
            if ($_SESSION['user_id'] == $row['user_id']) {
                echo ' <li> ' . htmlspecialchars($row['name']) . ' </li> ';
 } else {
                echo ' <li>  <a href=”cms_user_account.php?user_id=' .
  $row['user_id'] . '”> ' . htmlspecialchars($row['name']) . 
                    ' </a>  </li> ';
            }
        }
        echo ' </ul> ';
    }
    mysqli_free_result($result);
 }
 require 'cms_footer.inc.php';
 ?> 