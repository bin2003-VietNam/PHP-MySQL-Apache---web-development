<?php 
    session_start();
    if($_SESSION["authuser"] != 1){
        echo"sorry but you dont have permession to view this page";
        exit();
    }
?>

<html>
    <head>
        <title>
            <?php 
                if(isset($_POST["favmovie"])){
                    echo" - ";
                    echo $_GET["favmovie"];
                }
            ?>
        </title>
    </head>
    <body>
        <?php include 'welcome.php' ?>
        <?php 
            $favmovies = array('life of briant',
            'Stripes',
            'Office Space',
            'The holy Grail',
            'Matrix',
            'Terminator 2',
            'Close Encounters of the third kind',
            'Sixteen Candles',
            'Caddyack',
            'bbinn');
        
        
            // function listmovies_1(){
            //     echo '1. life of briant <br/>';
            //     echo '2. Stripes <br/>';
            //     echo '3. Office Space <br/>';
            //     echo '4. The holy Grail <br/>';
            //     echo '5. Matrix <br/>';
            // }

            // function listmovies_2(){
            //     echo '6. Terminator 2 <br/>';
            //     echo '7. Close Encounters of the third kind<br/>';
            //     echo '8. Sixteen Candles<br/>';
            //     echo '9. Caddyack<br/>';
            //     echo '10. bbinn<br/>';
            // }

            if(isset($_GET['favmovie'])){
                echo 'welcome to our site, ';
                echo $_SESSION['username'];
                echo '! <br/>';
                echo 'my favorite movie is ';
                echo $_GET['favmovie'];
                echo '<br/>';
                $movierate = 5;
                echo'My movie rating for this movie is: ';
                echo $movierate;
            }else{
                echo 'My top 10 favorite movies are: <br/>';
                if(isset($_GET['sorted'])){
                    sort($favmovies);
                }
                echo '<ol>';
                foreach($favmovies as $movie){
                    echo '<li>';
                    echo $movie;
                    echo '</li>';
                }
                echo '</ol>';
            }

        ?>
    </body>
</html>