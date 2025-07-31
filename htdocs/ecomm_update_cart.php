 <?php
 require 'db.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die ('Unable to connect. Check your connection parameters.');
                   
session_start();
$session = session_id();
                   
$qty = (isset($_POST['qty'])  &&  ctype_digit($_POST['qty'])) ? $_POST['qty'] : 0;
$product_code = (isset($_POST['product_code'])) ? $_POST['product_code'] : '';
$action = (isset($_POST['submit'])) ? $_POST['submit'] : '';
$redirect = (isset($_POST['redirect'])) ? $_POST['redirect'] : 'ecomm_shop.php';

if($action == 'Add to Cart'){
    print_r($qty);
}

switch ($action) {
 case 'Add to Cart':
    if (!empty($product_code)  &&  $qty >  0) {
        $query = 'INSERT INTO ecomm_temp_cart
                (session, product_code, qty)
            VALUES
                ("' . $session . '", "' .
                mysqli_real_escape_string($db, $product_code ) . '", ' . $qty . ')';
                mysqli_query($db,$query) or die(mysqli_error($db));
    }
    header('Location: ' . $redirect);
    exit();
    break;
                   
case 'Change Qty':
    if (!empty($product_code)) {
        if ($qty >  0) {
            $query = 'UPDATE ecomm_temp_cart
                SET
                    qty = ' . $qty . '
                WHERE
                    session = "' . $session . '" AND
                    product_code = "' .
                    mysqli_real_escape_string($db, $product_code ) . '"';
        } else {
            $query = 'DELETE FROM ecomm_temp_cart
                WHERE
                    session = "' . $session . '" AND
                    product_code = "' .
                    mysqli_real_escape_string($db, $product_code ) . '"';
        }
        mysqli_query($db,$query) or die(mysqli_error($db));
    }
    header('Location: ' . $redirect);
    exit();
    break;
                   
case 'Empty Cart':
    $query = 'DELETE FROM ecomm_temp_cart
        WHERE
            session = "' . $session . '"';
    mysqli_query($db,$query) or die(mysqli_error($db));
    header('Location: ' . $redirect);
    exit();
    break;
 }
 ?> 
