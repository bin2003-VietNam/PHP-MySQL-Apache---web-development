<?php 
    $to_address = $_POST["to_address"];
    $from_address = $_POST["from_address"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $headers = array();
    $headers[] ='MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'Content-Transfer-Encoding: 7bit';
    $headers[] = 'From: ' . $from_address; 
?>
<html>
    <head>
        <title>Mail sent</title>
    </head>
    <body>
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

            $mail->setFrom($from_address, 'bin');
            $mail->addAddress($to_address);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            
            $success = $mail->send();
            if ($success) { 
                echo 'Congratulation';
            }else{
                echo 'cant send mail';
            }

        ?>
    </body>
</html>