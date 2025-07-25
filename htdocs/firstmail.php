<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'nguyenvanbin.9a10@gmail.com'; // thay bằng email thật
$mail->Password = 'tclj urzw kkuo bxlq';    // là app password, KHÔNG dùng mật khẩu gmail thường
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('nguyenvanbin.9a10@gmail.com', 'bin');
$mail->addAddress('bin2003mail@gmail.com');
$mail->Subject = 'Test mail from PHP';
$mail->Body    = 'This is a test email from PHP using PHPMailer.';

$mail->send();
echo "Mail sent!";
?>
