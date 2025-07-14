<?php 
    //setcookie('username', 'bin', time()+60, '/');
    session_start();
    //$_SESSION["username"] = "bin";
    $_SESSION["username"] = $_POST["user"];
    $_SESSION["userpass"] = $_POST["pass"];
    $_SESSION["authuser"] = 0;

    if(
        ($_SESSION["username"] == "bin")
         and 
        ($_SESSION["userpass"] == "12345")){
        $_SESSION["authuser"] = 1;
    }else{
        echo "Sorry, but you dont have permission to view this page";
        exit();
    }

?>

<html>
    <head>
        <title>find my favorite movie !</title>
    </head>
    <body>
        <?php include 'welcome.php' ?>
        <?php 
            $favmovie = urlencode('Life of bin');
            echo "<a href=\"firstprog.php?id=1234&lang=en&rate=2&favmovie=$favmovie\">";
            echo 'Click me';
            echo '</a>';
        ?>
        <br/>
        <a href="moviesite.php">Click here to see my 10 movies.</a>
        <br/>
        <a href="moviesite.php?sorted=true">Click here to see my top 10 movies sorted alphabetically.</a>
    </body>
</html>