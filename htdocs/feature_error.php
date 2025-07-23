<?php
// Tạo custom error handler
function my_error_handler($error_number, $error_string, $filename, $line_number) {
    $msg = "Errors have occurred while executing a page.\n\n";
    $msg .= "Error Type: $error_number\n";
    $msg .= "Error Message: $error_string\n";
    $msg .= "Filename: $filename\n";
    $msg .= "Line Number: $line_number\n";
    $msg = wordwrap($msg, 75);

    switch ($error_number) {
        case E_ERROR:
        case E_USER_ERROR:
            mail('admin@example.com', 'Fatal Error from Website', $msg);
            die(); // Dừng chương trình
            break;

        case E_WARNING:
        case E_USER_WARNING:
            mail('admin@example.com', 'Warning from Website', $msg);
            break;

        case E_NOTICE:
        case E_USER_NOTICE:
            // Có thể bỏ qua hoặc xử lý tùy ý
            break;

        default:
            // Các lỗi khác
            break;
    }
}

// Gán custom error handler
set_error_handler('my_error_handler');

// Nếu bạn đang test và muốn nhìn thấy lỗi, thì bật dòng dưới:
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Dòng này là để tắt tất cả lỗi khỏi hiển thị (chỉ gửi email):
error_reporting(0);

// ❗ Tạo lỗi để test (thiếu tham số thứ 3 trong str_replace → E_WARNING)
echo $a;
echo 'hi';
?>
