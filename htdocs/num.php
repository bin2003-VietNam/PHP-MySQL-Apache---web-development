 <?php
 session_start();
 require 'db.inc.php';
                   
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DB ) or
    die ('Unable to connect. Check your connection parameters.');
                                      
$now = date('Y-m-d H:i:s');
$session = session_id();
                   
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address_1 = $_POST['address_1'];
$address_2 = $_POST['address_2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$phone = $_POST['phone'];
$email = $_POST['email'];
                   
$shipping_first_name = $_POST['shipping_first_name'];
$shipping_last_name = $_POST['shipping_last_name'];
$shipping_address_1 = $_POST['shipping_address_1'];
$shipping_address_2 = $_POST['shipping_address_2'];
$shipping_city = $_POST['shipping_city'];
$shipping_state = $_POST['shipping_state'];
$shipping_zip_code = $_POST['shipping_zip_code'];
$shipping_phone = $_POST['shipping_phone'];
$shipping_email = $_POST['shipping_email'];
                   
// assign customer id to new customer, or find existing customer id
 $query = 'SELECT
        customer_id
    FROM
        ecomm_customers
 WHERE
        first_name = "' . mysqli_real_escape_string($db,$first_name) . '" AND
        last_name = "' . mysqli_real_escape_string($db,$last_name) . '" AND
        address_1 = "' . mysqli_real_escape_string($db,$address_1) . '" AND
        address_2 = "' . mysqli_real_escape_string($db,$address_2) . '" AND
        city = "' . mysqli_real_escape_string($db,$city) . '" AND
        state = "' . mysqli_real_escape_string($db,$state) . '" AND
        zip_code = "' . mysqli_real_escape_string($db,$zip_code) . '" AND
        phone = "' . mysqli_real_escape_string($db,$phone) . '" AND
        email = "' . mysqli_real_escape_string($db,$email) . '"';
 $result = mysqli_query($db,$query) or (mysqli_error($db));
                   
if (mysqli_num_rows($result) >  0) {
    $row = mysqli_fetch_assoc($result);
    extract($row);
 } else {
    $query = 'INSERT INTO ecomm_customers
            (customer_id, first_name, last_name, address_1, address_2, city,
            state, zip_code, phone, email)
        VALUES
            (NULL,
            "' . mysqli_real_escape_string($db,$first_name) . '",
            "' . mysqli_real_escape_string($db,$last_name) . '",
            "' . mysqli_real_escape_string($db,$address_1) . '",
            "' . mysqli_real_escape_string($db,$address_2) . '",
            "' . mysqli_real_escape_string($db,$city) . '",
            "' . mysqli_real_escape_string($db,$state) . '",
            "' . mysqli_real_escape_string($db,$zip_code) . '",
            "' . mysqli_real_escape_string($db,$phone) . '",
            "' . mysqli_real_escape_string($db,$email) . '")';
    mysqli_query($db,$query) or (mysqli_error($db));
    $customer_id = mysqli_insert_id($db);
 }
 mysqli_free_result($result);
                   
// start order entry
 $query = 'INSERT into ecomm_orders
        (order_id, order_date, customer_id, cost_subtotal, cost_total,
        shipping_first_name, shipping_last_name, shipping_address_1,
        shipping_address_2, shipping_city, shipping_state, shipping_zip_code,
        shipping_phone, shipping_email)
    VALUES
            (NULL,
            "' . $now . '",
            ' . $customer_id . ',
            0.00,
            0.00,
            "' . mysqli_real_escape_string($db,$shipping_first_name) . '",
            "' . mysqli_real_escape_string($db,$shipping_last_name) . '",
            "' . mysqli_real_escape_string($db,$shipping_address_1) . '",
            "' . mysqli_real_escape_string($db,$shipping_address_2) . '",
            "' . mysqli_real_escape_string($db,$shipping_city) . '",
            "' . mysqli_real_escape_string($db,$shipping_state) . '",
  "' . mysqli_real_escape_string($db,$shipping_zip_code) . '",
            "' . mysqli_real_escape_string($db,$shipping_phone) . '",
            "' . mysqli_real_escape_string($db,$shipping_email) . '")';
    mysqli_query($db,$query) or (mysqli_error($db));
    $order_id = mysqli_insert_id($db);
                   
// Move order information from ecomm_temp_cart into ecomm_order_details
 $query = 'INSERT INTO ecomm_order_details
    (order_id, order_qty, product_code)
 SELECT
    ' . $order_id . ', qty, product_code
 FROM
    ecomm_temp_cart
 WHERE
    session = "' . $session . '"';
 mysqli_query($db,$query) or (mysqli_error($db));
                   
$query = 'DELETE FROM ecomm_temp_cart WHERE session = "' . $session . '"';
 mysqli_query($db,$query) or (mysqli_error($db));
                   
// retrieve subtotal
 $query = 'SELECT
        SUM(price * order_qty) AS cost_subtotal
    FROM
        ecomm_order_details d JOIN ecomm_products p ON
            d.product_code = p.product_code
    WHERE
        order_id = ' . $order_id;
 $result = mysqli_query($db,$query) or (mysqli_error($db));
 $row = mysqli_fetch_assoc($result);
 extract($row);
                   
// calculate shipping, tax and total costs
 $cost_shipping = round($cost_subtotal * 0.25, 2);
 $cost_tax = round($cost_subtotal * 0.1, 2);
 $cost_total = $cost_subtotal + $cost_shipping + $cost_tax;
                   
// upate costs in ecomm_orders
 $query = 'UPDATE ecomm_orders
    SET
        cost_subtotal = ' . $cost_subtotal . ',
        cost_shipping = ' . $cost_shipping . ',
        cost_tax = ' . $cost_tax . ',
        cost_total = ' . $cost_total . '
    WHERE
        order_id = ' . $order_id;
 mysqli_query($db,$query) or (mysqli_error($db));
                   
ob_start();
 ?> 
