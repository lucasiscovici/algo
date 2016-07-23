<?php
$user=1;
$type="movie";

require "base.php";

$movie=movie_pref($user);


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jTinder Touch Slider</title>
    <link rel="stylesheet" type="text/css" href="css/jTinder.css">
</head>
<body>
    <!-- start padding container -->
    <div class="wrap">
        <!-- start jtinder container -->
        <div id="tinderslide">
            <ul>
            <? $m=20; 
             foreach ($movie as $key => $value) {
                ?>
            <li class="pane" style="z-index:<?php echo $m ?>;" id="<?php echo $value['id'] ?>" rate='<?php echo $value["rate"] ?>'>
                    <div class="img" style="z-index:<?php echo $m ?>;"><img width="100%" style="z-index:<?php echo $m ?>;" height="100%" src="<?php echo $value["href"]?>"/></div>
                    <div class="tv" style="z-index:<?php echo $m ?>;" ><?php echo $value["title"]?></div><div class="tv" style="z-index:<?php echo $m ?>;"> Réal:
                    <?
                    $m--;
                     foreach ($value["reals"] as $key2 => $value2) {
                        ?>
                        <span class="tv" style="z-index:<?php echo $m ?>;"><?php echo $value2 ?></span>
                     <?}?></br>
                            <span class="tv" style="z-index:<?php echo $m ?>;"> Note:<?php echo $value["rate"] ?></span>                     </div>
             

                    <div class="like" style="z-index:<?php echo $m ?>;"></div>
                    <div class="dislike" style="z-index:<?php echo $m ?>;"></div>
                                        <div class="play" style="z-index:<?php echo $m ?>;" id="<?php echo $value['video']?>"></div>

                                                            <div class="seen" style="z-index:<?php echo $m ?>;"></div>

                </li>
            <?

            } 
                ?>
               
            </ul>
        </div>
        <!-- end jtinder container -->
    </div>
    <!-- end padding container -->

    <!-- jTinder trigger by buttons  -->
    <div class="actions">
        <a href="#" class="dislike"><i></i></a>
        <a href="#" class="like"><i></i></a>
                <a href="#" class="seen"><i></i></a>

    </div>

    <!-- jTinder status text  -->
    <div id="status"></div>

    <!-- jQuery lib -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- transform2d lib -->
    <script type="text/javascript" src="js/jquery.transform2d.js"></script>
    <!-- jTinder lib -->
    <script type="text/javascript" src="js/jquery.jTinder.js"></script>
    <!-- jTinder initialization script -->
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>