<?php
// Kết nối MySQL
$db = mysqli_connect('localhost', 'edna', 'ednapass', 'moviesite') 
    or die('Unable to connect. Check your connection parameters.');

// Thư mục chứa ảnh và thumbnail
$dir = 'images';
$thumbdir = $dir . '/thumbs';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to our Photo Gallery</title>
    <style>
        th { background-color: #999; }
        .odd_row { background-color: #EEE; }
        .even_row { background-color: #FFF; }
    </style>
</head>
<body>
    <p>Click on any image to see it full sized.</p>
    <table style="width:100%;">
        <tr>
            <th>Image</th>
            <th>Caption</th>
            <th>Uploaded By</th>
            <th>Date Uploaded</th>
        </tr>
<?php
// Lấy danh sách ảnh
$query = "SELECT * FROM images";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

$odd = true;
while ($row = mysqli_fetch_assoc($result)) {
    $row_class = $odd ? 'odd_row' : 'even_row';
    $odd = !$odd;

    $image_id = $row['image_id'];
    $image_caption = $row['image_caption'];
    $image_username = $row['image_username'];
    $image_date = $row['image_date'];

    echo "<tr class='$row_class'>";
    echo "<td><a href='$dir/$image_id.jpg'><img src='$dir/$image_id.jpg' width=\"60\" height=\"60\" /></a></td>";
    echo "<td>$image_caption</td>";
    echo "<td>$image_username</td>";
    echo "<td>$image_date</td>";
    echo "</tr>";
}
?>
    </table>
</body>
</html>
