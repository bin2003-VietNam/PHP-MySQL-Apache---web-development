<?php
session_start();
require 'db.inc.php';
?>
<html>
<head>
    <title>Here is Your Shopping Cart!</title>
    <style type="text/css">
        th { background-color: #999; }
        td { vertical-align: top; }
        .odd_row { background-color: #EEE; }
        .even_row { background-color: #FFF; }
        img{
        width: 50px;
        height: 50px;
    }
    </style>
</head>
<body>
    <h1>Comic Book Appreciation Store</h1>

<?php
$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or
    die('Unable to connect. Check your connection parameters.');

$session = session_id();

$query = "SELECT
                t.product_code, t.qty,
                p.name, p.description, p.price
            FROM
                ecomm_temp_cart t
                JOIN ecomm_products p ON TRIM(t.product_code) = TRIM(p.product_code)
            WHERE
                t.session = '$session'
            ORDER BY
                t.product_code;";

$result = mysqli_query($db, $query) or die(mysqli_error($db));
$rows = mysqli_num_rows($result);

if ($rows == 1) {
    echo '<p>You currently have 1 product in your cart.</p>';
} else {
    echo '<p>You currently have ' . $rows . ' products in your cart.</p>';
    echo "Session: $session";

}

if ($rows > 0) {
?>
    <table style="width: 75%;">
        <tr>
            <th style="width: 100px;"></th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price Each</th>
            <th>Extended Price</th>
        </tr>
<?php
    $total = 0;
    $odd = true;
    while ($row = mysqli_fetch_array($result)) {
        $row_class = $odd ? 'odd_row' : 'even_row';
        $odd = !$odd;
        extract($row);
?>
        <tr class="<?php echo $row_class; ?>">
            <td style="text-align:center;">
                <a href="ecomm_view_product.php?product_code=<?php echo $product_code; ?>">
                    <img src="images/<?php echo trim($product_code);?>.jpg" alt="<?php echo $name; ?>"/>
                </a>
            </td>
            <td>
                <a href="ecomm_view_product.php?product_code=<?php echo $product_code; ?>">
                    <?php echo $name; ?>
                </a>
            </td>
            <td>
                <form method="post" action="ecomm_update_cart.php">
                    <div>
                        <input type="text" name="qty" maxlength="2" size="2" value="<?php echo $qty; ?>"/>
                        <input type="hidden" name="product_code" value="<?php echo $product_code; ?>"/>
                        <input type="hidden" name="redirect" value="ecomm_view_cart.php"/>
                        <input type="submit" name="submit" value="Change Qty"/>
                    </div>
                </form>
            </td>
            <td style="text-align: right;">$<?php echo $price; ?></td>
            <td style="text-align: right;">$<?php echo number_format($price * $qty, 2); ?></td>
        </tr>
<?php
        $total += $price * $qty;
    }
?>
    </table>
    <p>Your total before shipping is:
        <strong>$<?php echo number_format($total, 2); ?></strong>
    </p>
    <form method="post" action="ecomm_checkout.php">
        <div>
            <input type="submit" name="submit" value="Proceed to Checkout" style="font-weight: bold;"/>
        </div>
    </form>
    <form method="post" action="ecomm_update_cart.php">
        <div>
            <input type="hidden" name="redirect" value="ecomm_shop.php"/>
            <input type="submit" name="submit" value="Empty Cart"/>
        </div>
    </form>
<?php
}
?>
    <hr/>
    <p><a href="ecomm_shop.php"><< Back to main page</a></p>
</body>
</html>
