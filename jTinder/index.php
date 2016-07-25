<?php
session_start();
// print_r($_SESSION["id"]);
require "base.php";
// print_r($_SESSION["id"]);
if (!isset($_SESSION["id"])) {
header('Location: recherche.php');
  exit();
}else{
  $user=$_SESSION["id"];
$movie=movie_pref($user);
// print_r(count($movie));
if (count($movie)==0) {
    print_r("pas de suggestion");
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">



    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jTinder Touch Slider</title>
    <link rel="stylesheet" type="text/css" href="css/jTinder.css">
        <link rel="stylesheet" type="text/css" href="js/rateit.js/scripts/rateit.css">

</head>
<body>
    <!-- start padding container -->

    <div class="wrap">
        <!-- start jtinder container -->
        <div id="tinderslide">
            <ul>
            <? $m=5; 
             foreach ($movie as $key => $value) {
                ?>
            <li class="pane" tmdb_id="<?php echo $value['tmdb_id'] ?>" style="z-index:<?php echo $m ?>;" p_id="<?php echo $value['p_id'] ?>" rate='<?php echo $value["rate"] ?>' user="<?php echo $user ?>">
                    <div class="img" url="<?php echo $value["url"]?>" style="z-index:<?php echo $m ?>;"><img id="img_img" width="100%" style="z-index:<?php echo $m ?>;" height="100%" src="<?php echo $value["href"]?>"/></div>
                    <div class="tv" id="title_title" style="z-index:<?php echo $m ?>;" ><?php echo $value["title"]?></div><div id="real_1" class="tv" style="z-index:<?php echo $m ?>;"> Réal:
                    <?
                    
                     foreach ($value["reals"] as $key2 => $value2) {
                        ?>
                        <span class="tv" id="real_real" style="z-index:<?php echo $m ?>;"><?php echo $value2 ?></span>
                     <?}?></br>
                            <span class="tv" style="z-index:<?php echo $m ?>;"> Note:<?php echo $value["rate"] ?></span>
                            </br>Année:
                            <span class="tv" id="ann_ann" style="z-index:<?php echo $m ?>;"> <?php echo $value["ann"] ?></span>
                                                 </div>
             

                    <div class="like" style="z-index:<?php echo $m ?>;"></div>
                    <div class="dislike" style="z-index:<?php echo $m ?>;"></div>
                    <? if ($value["video_url"] != "fail"){?>
                    <div class="play" style="z-index:<?php echo $m ?>;" v_id="<?php echo $value['video_url']?>"></div>
<? }?>
                    <div class="seen" style="z-index:<?php echo $m ?>;"></div>
<i class="fa fa-info-circle" id="nfo" aria-hidden="true"></i>

                </li>
            <?
$m++;
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
        <a href="#" class="seen"><i class="fa fa-eye fa-3" aria-hidden="true"></i></a>
        <a href="#" class="like"><i></i></a>

                

    </div>

    <!-- jTinder status text  -->
    <div id="status"></div>
    <div id="pom"><p><?php  print_r($gl); ?></p><p>
    <?php print_r($list_name); ?>
    </p></div>
    <div class="modal fade" id="modal2" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
      <div class="row">
      <div class="col-lg-6">
      <div class="play" v_id=""> </div>

      <img id="img_modal"     width="100%" src=""/>
      </div>
            <div class="col-lg-6">

     <p> title: <span id="title_modal"></span></br>
     reals: <span id="real_modal"></span> </p>
     genres: <span id="genre_modal"></span> </p>
     synopsis: <span id="synop_modal"></span> </p>
          année: <span id="ann_modal"></span> </p>

     </div>
     </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
      <div class="rateit bigstars" id="rateit5" step="0.1" data-rateit-step="0.1" data-rateit-min="0" data-rateit-value="2.5" data-rateit-resetable='false' data-rateit-starwidth="32" data-rateit-starheight="32">
</div>
<div>
    <span id="value5"></span>
    <span id="hover5"></span>
</div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sv" >Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <!-- jQuery lib -->

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- transform2d lib -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
         <script type="text/javascript" src="js/rateit.js/scripts/jquery.rateit.js"></script>

    <script type="text/javascript" src="js/jquery.transform2d.js"></script>
    <!-- jTinder lib -->
    <script type="text/javascript" src="js/jquery.jTinder.js"></script>
    <!-- jTinder initialization script -->
    <script type="text/javascript" src="js/main.js"></script>

  
    <script type="text/javascript">
    $('#hover5').text($("#rateit5").rateit("value")); 
    $("#rateit5").bind('rated', function (event, value) { $('#value5').text('You\'ve rated it: ' + value); });
    $("#rateit5").bind('reset', function () { $('#value5').text('Rating reset'); });
        $("#rateit5").bind('over', function (event, value) { 
            console.log(value);
            if (value=="null" || value==null){console.log("j");value=$("#rateit-range-2").attr("aria-valuenow");}
            console.log(value);
            $('#hover5').text(value); 
        });

</script> 
</body>
<?php

}
?>
</html>