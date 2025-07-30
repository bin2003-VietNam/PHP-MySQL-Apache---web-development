<?php
require 'db.inc.php';
require 'class.SimpleMail.php';

$db = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DB) or
    die('Unable to connect. Check your connection parameters.');

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';
echo $action;
switch ($action) {
    case 'Add New Mailing List':
        $listname = isset($_POST['listname']) ? $_POST['listname'] : '';
        if (!empty($listname)) {
            $query = 'INSERT INTO ml_lists
                    (listname)
                VALUES
                    ("' . mysqli_real_escape_string($db,$listname) . '")';
            mysqli_query($db,$query ) or die(mysqli_error($db));
        }
        break;
    case 'Delete Mailing List':
        $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
        if (ctype_digit($ml_id)) {
            $query = 'DELETE FROM ml_lists WHERE ml_id=' . $ml_id;
            mysqli_query($db,$query) or die(mysqli_error($db));
            $query = 'DELETE FROM ml_subscriptions WHERE ml_id=' . $ml_id;
            mysqli_query($db,$query) or die(mysqli_error($db));
        }
    break;
    case 'Send Message':
        $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        if ($ml_id == 'all') {
            $listname = 'Master';
            break;
        } else if (ctype_digit($ml_id)) {
            $query = 'SELECT
                    listname
                FROM
                    ml_lists
                WHERE
                    ml_id=' . $ml_id;
            $result = mysqli_query($db,$query ) or die(mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
            $listname = $row['listname'];
            mysqli_free_result($result);
            break;
        } else {
            break;
        }
    case 'Subscribe':
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $query = "SELECT user_id FROM ml_users WHERE email='" . mysqli_real_escape_string($db, $email) . "'";
        $result = mysqli_query($db,$query ) or die(mysqli_error($db));
        echo "hi"; 
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
        } else {
            $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
            $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';

            $query = "INSERT INTO ml_users (first_name, last_name, email) VALUES ('" .
                mysqli_real_escape_string($db, $first_name ) . "', '" .
                mysqli_real_escape_string($db, $last_name) . "', '" .
                mysqli_real_escape_string($db,$email ) . "')";
            mysqli_query($db,$query ) or die('cannot insert to ml_users');
            $user_id = mysqli_insert_id($db);
        }
        mysqli_free_result($result);

        foreach ($_POST['ml_id'] as $ml_id) {
            if (ctype_digit($ml_id)) {
                $query = "INSERT INTO ml_subscriptions (user_id, ml_id, pending) VALUES ($user_id, $ml_id, TRUE)";
                mysqli_query($db,$query );

             $query = "SELECT listname FROM ml_lists WHERE ml_id = $ml_id";
                $result = mysqli_query($db,$query );
                $row = mysqli_fetch_assoc($result);
                $listname = $row['listname'];

                $message = "Hello $first_name,\n";
                $message .= "Our records indicate that you have subscribed to the '$listname' mailing list.\n\n";
                $message .= "If you did not subscribe, please accept our apologies. You will not be subscribed if you do not visit the confirmation URL.\n\n";
                $message .= "If you subscribed, please confirm this by visiting the following URL:\n";
                $message .= "http://www.example.com/ml_user_transact.php?user_id=$user_id&ml_id=$ml_id&action=confirm";

                $mail = new SimpleMail();
                $mail->setToAddress($email);
                $mail->setFromAddress('list@example.com');
                $mail->setSubject('Mailing list confirmation');
                $mail->setTextBody($message);
                $mail->send();
                unset($mail);
            }
        }

        header("Location: ml_thanks.php?user_id=$user_id&ml_id=$ml_id&type=c");
        break;

    case 'confirm':
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $ml_id = isset($_GET['ml_id']) ? $_GET['ml_id'] : '';

        if (!empty($user_id) && !empty($ml_id)) {
            $query = "UPDATE ml_subscriptions SET pending = FALSE WHERE user_id = $user_id AND ml_id = $ml_id";
            mysqli_query($db,$query );

         $query = "SELECT listname FROM ml_lists WHERE ml_id = $ml_id";
            $result = mysqli_query($db,$query );
            $row = mysqli_fetch_assoc($result);
            $listname = $row['listname'];
            mysqli_free_result($result);

            $query = "SELECT first_name, email FROM ml_users WHERE user_id = $user_id";
            $result = mysqli_query($db,$query );
            $row = mysqli_fetch_assoc($result);
            $first_name = $row['first_name'];
            $email = $row['email'];
            mysqli_free_result($result);

            $message = "Hello $first_name,\n";
            $message .= "Thank you for subscribing to the '$listname' mailing list. Welcome!\n\n";
            $message .= "If you did not subscribe, please accept our apologies. You can remove\n";
            $message .= "this subscription immediately by visiting the following URL:\n";
            $message .= "http://www.example.com/ml_remove.php?user_id=$user_id&ml_id=$ml_id";

            $mail = new SimpleMail();
            $mail->setToAddress($email);
            $mail->setFromAddress('list@example.com');
            $mail->setSubject('Mailing list subscription confirmed');
            $mail->setTextBody($message);
            $mail->send();

            header("Location: ml_thanks.php?user_id=$user_id&ml_id=$ml_id");
        } else {
            header("Location: ml_user.php");
        }
        break;

    case 'Remove':
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        if (!empty($email)) {
            $query = "SELECT user_id FROM ml_users WHERE email='" . mysqli_real_escape_string($db,$email) . "'";
            $result = mysqli_query($db,$query ) or die(mysqli_error($db));

            if (mysqli_num_rows($result)) {
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['user_id'];
                mysqli_free_result($result);

                // Bạn nên truyền ml_id cụ thể từ form nếu có
                $ml_id = isset($_POST['ml_id']) ? $_POST['ml_id'] : 0;

                header("Location: ml_remove.php?user_id=$user_id&ml_id=$ml_id");
                break;
            }
            mysqli_free_result($result);
        }
        header("Location: ml_user.php");
        break;
}
?>
