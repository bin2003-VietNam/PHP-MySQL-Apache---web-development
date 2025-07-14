<html>
    <body>
        <div style="text-align: center">
            <p>Welcome to my movie review site!</p><br/>
            <?php 
                date_default_timezone_set("America/New_york");
                echo "Today is ";
                echo date("F d");
                echo ", ";
                echo date("Y");
            ?>
            <br/>
        </div>
    </body>
</html>