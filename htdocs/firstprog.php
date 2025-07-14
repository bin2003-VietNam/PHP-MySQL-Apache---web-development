<?php 
    session_start();
    if($_SESSION["authuser"] != 1){
        echo 'Sorry, but you dont have permission to view this page';
        exit();
    }
?>

<html>
    <head>
        <title>My movie site - <?php echo $_GET['favmovie'];?></title>
    </head>
    <body>
        <?php 
            echo "<br/>";
            echo 'welcome to our site, ';
            //echo $_COOKIE['username'];
            echo $_SESSION['username'];
            echo '<br/>';
            define ("FAVMOVIE","the little of Brian");
            echo"My favorite movie is ";
            echo FAVMOVIE;
            echo "<br/>";
            $movierate = 5;
            echo "My movie rating for this movie is: ";
            echo $movierate;
            echo "<br/>";
            $var1 = 1;
            $var2 = 100;
            echo rand($var1, $var2);
            echo "<br/>";
            echo ceil($movierate / $var1);
            echo "<br/>";
            echo "max: "; echo max($var1, $var2);
            echo "<br/>";
            if($_GET["id"] == "1234") {
                echo "your id is: "; echo "1234";
            }else{
                echo "false";
            }
            echo "<br/>";
            echo "my favmovie rating is: "; echo $_GET["rate"];
            echo "<br/>";
            if($_GET["favmovie"]) {
                echo "there are favmovie: ";
                echo $_GET["favmovie"];
            }
        ?>

    </body>
</html>