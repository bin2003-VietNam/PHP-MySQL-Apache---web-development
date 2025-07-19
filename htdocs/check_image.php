<?php 
$db = mysqli_connect("localhost","edna","ednapass","moviesite")
    or die("". mysqli_connect_error());
$dir = 'C:\Apache24\htdocs\images';

//make sure the upload file transfer was successful
if($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK){
    switch($_FILES['uploadfile']['error']){
        case UPLOAD_ERR_INI_SIZE:
            die('The upload file exceeds the upload_maxfilesize directive' . 'in php.ini.');
            break;
        case UPLOAD_ERR_FORM_SIZE:
            die('The upload file exceeds the MAX_FILE_SIZE directive that was'. 
            'was specified in the HTML form');
            break;
        case UPLOAD_ERR_PARTIAL:
            die('The uploaded file was only partially uploaded.');
            break;
        case UPLOAD_ERR_NO_FILE:
            die('No file was uploaded.');
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            die('The server is missing a temporary folder.');
            break;
        case UPLOAD_ERR_CANT_WRITE:
            die('The server failed to write the uploaded file to disk.');
            break;
        case UPLOAD_ERR_EXTENSION:
            die('File upload stopped by extension.');
            break;
    }
}

//get info about the image being uploaded
$image_caption = $_POST['caption'] ?? '';
$image_username = $_POST['username'] ?? '';
$image_date = date('Y-m-d');
list($wdth, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);

// make sure the uploaded file is really a supported image
$type = exif_imagetype($_FILES['uploadfile']['tmp_name']);
switch ($type) {
    case IMAGETYPE_GIF:
        $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']);
        $ext = '.gif';
        break;
    case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']);
        $ext = '.jpg';
        break;
    case IMAGETYPE_PNG:
        $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']);
        $ext = '.png';
        break;
    default:
        die('The file you uploaded was not a supported filetype.');
}

// insert information into image table
$query = "INSERT INTO images (image_caption, image_username, image_date) VALUES (?, ?, ?)";


$stmt = mysqli_prepare($db, $query);
$stmt->bind_param("sss", $image_caption, $image_username, $image_date);
$stmt->execute();

// retrieve the image_id
$last_id = $stmt->insert_id;

// save the image to its final destination
$imagename = $last_id . '.jpg';
$imagename = $last_id . $ext;

switch ($type) {
    case IMAGETYPE_GIF:
        imagegif($image, $dir . '/' . $imagename);
        break;
    case IMAGETYPE_JPEG:
        imagejpeg($image, $dir . '/' . $imagename);
        break;
    case IMAGETYPE_PNG:
        imagepng($image, $dir . '/' . $imagename);
        break;
}



$width = imagesx($image);
$height = imagesy($image);
imagedestroy($image);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Here is your pic!</title>
</head>
<body>
    <h1>So how does it feel to be famous?</h1>
    <p>Here is the picture you just uploaded to our servers:</p>
    <img src="images/<?php echo $imagename; ?>" style="float:left;" alt="Uploaded Image">

    <table>
        <tr><td>Image Saved as:</td><td><?php echo $imagename; ?></td></tr>
        <tr><td>Height:</td><td><?php echo $height; ?></td></tr>
        <tr><td>Width:</td><td><?php echo $width; ?></td></tr>
        <tr><td>Upload Date:</td><td><?php echo $image_date; ?></td></tr>
    </table>
</body>
</html>

