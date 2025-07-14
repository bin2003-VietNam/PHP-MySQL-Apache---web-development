<html>
    <head>
        <title>movie</title>
    </head>
    <body>
        <?php 
            $favmovie = urldecode('Life of bin');
            echo "<a href=\"firstprog.php?id=1234&lang=en&rate=2&favmovie=$favmovie\">";
            echo 'Click me';
            echo '</a>';
        ?>
    </body>
</html>