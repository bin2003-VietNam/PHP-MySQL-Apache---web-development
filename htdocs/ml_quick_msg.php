<?php 
    require 'db.inc.php';
    $db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
    or die (mysqli_error($db));
?>
 <html> 
  <head> 
   <title> Send Message </title> 
   <style type="text/css"> 
   td { vertical-align: top; }
   </style> 
  </head> 
  <body> 
   <h1> Send Message </h1> 
   <form method="post" action="ml_admin_transact.php"> 
    <table> 
     <tr> 
      <td>  <label for="ml_id"> Mailing List: </label>  </td> 
      <td>  <select name="ml_id" id="ml_id"> 
        <option value="all"> All </option>
 <?php
 $query = 'SELECT ml_id, listname FROM ml_lists ORDER BY listname';
 $result = mysqli_query($db,$query) or die(mysqli_error($db));
                   
while ($row = mysqli_fetch_array($result)) {
    echo ' <option value="' . $row['ml_id'] . '"> ' . $row['listname'] .
        ' </option> ';
 }
 mysqli_free_result($result);
 ?> 
       </select>  </td> 
     </tr>  <tr> 
      <td>  <label for="subject"> Subject: </label>  </td> 
      <td>  <input type="text" name="subject" id="subject"/>  </td> 
     </tr>  <tr> 
      <td>  <label for="message"> Message: </label>  </td> 
      <td>  <textarea name="message" id="message" rows="10"
       cols="60">  </textarea>  </td> 
     </tr>  <tr> 
      <td>     </td> 
      <td>  <input type="submit" name="action" value="Send Message"/>  </td> 
     </tr>  <tr> 
    </table> 
   </form> 
   <p>  <a href="ml_admin.php"> Back to mailing list administration. </a>  </p> 
  </body>  
 </html> 