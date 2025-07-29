<?php
function redirect($url) {
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit; // nên thêm exit sau header để ngừng thực thi tiếp
    } else {
        die('Could not redirect; Output was already sent to the browser.');
    }
}
?>
