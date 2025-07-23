<?php
function my_error_handler($error_number, $error_string, $filename, $line_number) {
    switch ($error_number) {
        case E_ERROR:
        case E_USER_ERROR:
            echo '<h1>Fatal Error</h1>';
            echo '<p>A fatal error has occurred in ' . $filename . ' at line ' .
                $line_number . '.<br/>' . $error_string . '.</p>';
            die(); // Stop execution
            break;

        case E_WARNING:
        case E_USER_WARNING:
            echo '<h1>Warning</h1>';
            echo '<p>A warning has occurred in ' . $filename . ' at line ' .
                $line_number . '.<br/>' . $error_string . '.</p>';
            break;

        case E_NOTICE:
        case E_USER_NOTICE:
            // Optionally ignore notices
            break;

        default:
            echo '<h1>Unknown Error</h1>';
            echo '<p>An unknown error has occurred.<br/>' . $error_string . '</p>';
            break;
    }
}

echo $a;


?>
