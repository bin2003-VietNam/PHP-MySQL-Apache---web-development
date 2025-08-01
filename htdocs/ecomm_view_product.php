 <?php
 session_start();
                   
require 'db.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');
                   
$product_code = isset($_GET['product_code']) ? $_GET['product_code'] : '';
                   
$query = 'SELECT
        name, description, price
    FROM
        ecomm_products
    WHERE
        product_code = "' . mysqli_real_escape_string($db,$product_code )
 . '"';
 $result = mysqli_query($db,$query )or die(mysqli_error($db));
                   
if (mysqli_num_rows($result) != 1) {
header('Location: ecomm_shop.php');
    mysqli_free_result($result);
    mysqli_close($db);
    exit();
 }
 $row = mysqli_fetch_assoc($result);
 extract($row);
 ?> 
 <html> 
  <head> 
   <title>  <?php echo $name; ?>  </title> 
   <style type="text/css"> 
   th { background-color: #999;}
   td { vertical-align: top; }
   .odd_row { background-color: #EEE; }
   .even_row { background-color: #FFF; }
   img{
        width: 100px;
        height: 100px;
    }
   </style> 
  </head> 
  <body> 
   <h1> Comic Book Appreciation Store </h1> 
   <p>  <a href="ecomm_view_cart.php"> View Cart </a>  </p> 
   <h2>  <?php echo $name; ?>  </h2> 
   <table> 
    <tr> 
     <td rowspan="4">  <img src="images/<?php echo $product_code ?>.jpg"
      alt=" <?php echo $name; ?> " style="width: 50px;height:50px"/>  </td> 
     <td>  <?php echo $description; ?>  </td> 
    </tr>  <tr> 
     <td>  <strong> Product Code: </strong>     <?php echo $product_code; ?>  </td> 
    </tr>  <tr> 
     <td>  <strong> Price: </strong>  $ <?php echo $price; ?>  </td> 
    </tr>  <tr> 
     <td> 
      <form method="post" action="ecomm_update_cart.php"> 
       <div> 
        <input type="hidden" name="product_code"
        value=" <?php echo $product_code; ?> "/> 
        <label for="qty"> Quantity:  </label> 
 <?php
 echo ' <input type="hidden" name="redirect" value="ecomm_view_product.php?' . 
    'product_code=' . $product_code . '"/> ';
                   
$session = session_id();
 $query = 'SELECT
        qty
    FROM
        ecomm_temp_cart
    WHERE
        session = "' . $session . '" AND
        product_code = "' . $product_code . '"';
 $result = mysqli_query($db,$query)or die(mysqli_error($db));
                   
if (mysqli_num_rows($result) >  0) {
    $row = mysqli_fetch_assoc($result);
  extract($row);
 } else {
    $qty = 0;
 }
 mysqli_free_result($result);
                   
echo ' <input type="text" name="qty" id="qty" size="2" maxlength="2" value="' .
    $qty . '"/> ';
                   
if ($qty >  0) {
    echo ' <input type="submit" name="submit" value="Change Qty"/> ';
 } else {
    echo ' <input type="submit" name="submit" value="Add to Cart"/> ';
 }
 ?> 
       </div> 
      </form> 
     </td> 
    </tr> 
   </table> 
   <hr/> 
   <p>  <a href="ecomm_shop.php">  < < Back to main page </a>  </p> 
  </body> 
 </html> 