<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beginning PHP7, Apache, MySQL Web Development Custom Error Page</title>
</head>
<body>
    <?php 
        switch ($_SERVER['QUERY_STRING']) {
            case '400':
                echo '<h1>Bad Request</h1>';
                echo '<h2>Error Code 400</h2>';
                echo '<p>The browser has made a Bad Request.</p>';
                break;

            case 401:
                echo '<h1>Authorization Required</h1>';
                echo '<h2>Error Code 401</h2>';
                echo '<p>You have supplied the wrong information to access a secure resource.</p>';
                break;

            case 403:
                echo '<h1>Access Forbidden</h1>';
                echo '<h2>Error Code 403</h2>';
                echo '<p>You have been denied access to this resource.</p>';
                break;

            case 404:
                echo '<h1>Page Not Found</h1>';
                echo '<h2>Error Code 404</h2>';
                echo '<p>The page you are looking for cannot be found.</p>';
                break;

            case 500:
                echo '<h1>Internal Server Error</h1>';
                echo '<h2>Error Code 500</h2>';
                echo '<p>The server has encountered an internal error.</p>';
                break;

            default:
                echo '<h1>Error Page</h1>';
                echo '<p>This is a custom error page...</p>';
        }

        echo '<p><a href="mailto:sysadmin@example.com">Contact</a> the system administrator if you feel this to be in error.</p>';
        $now = (isset($_SERVER['REQUEST_TIME'])) ? $_SERVER['REQUEST_TIME'] : time();
        $page = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : 'unknown';

        $msg = wordwrap('A ' . $_SERVER['QUERY_STRING'] . ' error was encountered on' .
        date('F d, Y' $now) . ' at ' . date('H:i:sa T', $now) . 'when a ' . ' visitor attempted to view' . 
        $page . '.');
        mail('nguyenvanbin.9a10@gmail.com', 'Error from Website', $msg);
        ?>
    
</body>
</html>