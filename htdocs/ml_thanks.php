 <html> 
  <head> 
   <title> Thank You </title> 
  </head> 
  <body> 
 <?php
 require 'db.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');
                                      
$user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '';
$ml_id = (isset($_GET['ml_id'])) ? $_GET['ml_id'] : '';
$type = (isset($_GET['type'])) ? $_GET['type'] : '';
                   
if (empty($user_id)) {
    die('No user id available.');
 }
 $query = 'SELECT first_name, email FROM ml_users WHERE user_id = ' .
    $user_id;
 $result = mysqli_query($db,$query) or die(mysqli_error($db));
                   
if (mysqli_num_rows($result) >  0) {
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['first_name'];
    $email = $row['email'];       
} else {
    die('No match for user id.');
 }
 mysqli_free_result($result);
                   
if (empty($ml_id)) {
    die('No mailing list id available.');
 }
 $query = 'SELECT listname FROM ml_lists WHERE ml_id = ' . $ml_id;
 $result = mysqli_query($db,$query) or die(mysqli_error($db));
                   
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $listname = $row['listname'];
 } else {
    die ('No match for mailing list id');
 }
 mysqli_free_result($result);
                   
if ($type == 'c') {
    echo ' <h1> Thank You ' . $first_name . ' </h1> ';
    echo ' <p> A confirmation for subscribing to the ' . $listname . 
' mailing list ' . 
        'has been sent to ' . $email . '. </p> ';
 } else {
    echo ' <h1> Thank You ' . $first_name . ' </h1> ';
    echo ' <p> Thank you for subscribing to the ' . $listname . ' 
mailing list. </p> ';
 }
 ?> 
  </body> 
 </html> 