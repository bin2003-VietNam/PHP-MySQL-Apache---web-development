<?php
 require 'db.inc.php';
 $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');

 $user_id = (isset($_GET['user_id'])  &&  ctype_digit($_GET['user_id'])) ?
 $_GET['user_id'] : '';
 $first_name = '';
 $last_name = '';
 $email = '';
 $ml_ids = array();
                   
if (!empty($user_id)) {
    $query = 'SELECT
            first_name, last_name, email
        FROM 
            ml_users
        WHERE
            user_id = ' . $user_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));
    if (mysqli_num_rows($result) >  0) {
        $row = mysqli_fetch_assoc($result);
        extract($row);
    }
    mysqli_free_result($result);
                   
    $query = 'SELECT ml_id FROM ml_subscriptions WHERE user_id = ' . $user_id;
    $result = mysqli_query($db,$query) or die(mysqli_error($db));
    while ($row = mysqli_fetch_assoc($result)) {
        $ml_ids[] = $row['ml_id'];
    }
    mysqli_free_result($result);
 }
 ?> 
 <html> 
  <head> 
   <title> Mailing List Signup </title> 
  </head> 
  <body> 
   <h1> Sign up for Mailing List: </h1> 
   <form method="post" action="ml_user_transact.php"> 
    <table> 
     <tr> 
      <td>  <label for="email"> Email Address: </label>  </td> 
      <td>  <input type="text" name="email" id="email" value=" <?php echo $email; ?> "/> 
      </td> 
     </tr> 
    </table> 
    <p> If you aren't currently a member, please provide your name: </p> 
    <table> 
     <tr> 
      <td>  <label for="first_name"> First Name: </label>  </td> 
      <td>  <input type="text" name="first_name" id="first_name"
       value=" <?php echo $first_name; ?> "/>  </td> 
     </tr>  <tr> 
      <td>  <label for="last_name"> Last Name: </label>  </td> 
      <td>  <input type="text" name="last_name" id="last_name"
       value=" <?php echo $last_name; ?> "/>  </td> 
     </tr> 
    </table> 
 <p> Select the mailing lists you want to receive: </p> 
    <p> 
     <select name="ml_id[]" multiple="multiple"> 
 <?php
 $query = 'SELECT
        ml_id, listname
    FROM
        ml_lists
    ORDER BY
        listname ASC';
 $result = mysqli_query($db,$query) or die(mysqli_error($db));
                   
print_r($ml_ids);
while ($row = mysqli_fetch_array($result)) {
    if (in_array($row['ml_id'], $ml_ids)) { 
        echo ' <option value="' . $row['ml_id'] . '" selected="selected"> ';
    } else {
        echo ' <option value="' . $row['ml_id'] . '"> ';
    }
    echo $row['listname'] . ' </option> ';
 }
 mysqli_free_result($result);
 ?> 
     </select> 
    </p> 
    <p>  <input type="submit" name="action" value="Subscribe" />  </p> 
   </form> 
  </body> 
 </html> 