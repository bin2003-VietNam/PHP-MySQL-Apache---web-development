<html>
    <head>

    </head>
    <body>
        <?php 
            $flavor[] = 'blue bin';
            $flavor[] = 'root beer';
            $flavor[] = 'pineapple';

            echo 'my favorite flavor are: <br/>';
            foreach ($flavor as $current_flavor) { 
                echo $current_flavor;echo '<br/>';
            }
        ?>
    </body>
</html>