<?php 
session_start();

include 'begin_session.php';
if (isset($_POST["id"])) {
	session_id($_POST["idd"]);
	$_SESSION["id"]=$_POST["id"];
	$_SESSION["pseudo"]=$_POST["pseudo"];
	$pseudo=$_SESSION["pseudo"];
	$user=$_SESSION["id"];
}
include "base.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">



    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jTinder Touch Slider</title>
    <link rel="stylesheet" type="text/css" href="css/jTinder.css">
        <link rel="stylesheet" type="text/css" href="js/rateit.js/scripts/rateit.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<style type="text/css">
.ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
	.ui-autocomplete {
    max-height: 300px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 300px;
  }
</style>
</head>
<body>
    <!-- start padding container -->
    <p style="text-align:center;font-size:30px" id="us" ><?php echo $user ?> - <?php echo $pseudo ?><p>
<div class="ui-widget">
  <label for="tags">Nom du film: </label>
  <input id="tags">
</div>
<div style="right:50px;position:absolute;">
<a href="JavaScript:void(0);" id="btn-remove">&laquo; Remove</a>
 
    <select name="selectto" id="select-to" style="width:200px;" multiple size="5">
      
    </select>
    </div>
   <p  style="text-align:center;">  <input type="button" name="new user"  style="text-align:center;" id="nu" value="new user" title="new user"/>
        <input type="button" name="change user" id="cu" value="change user" style="text-align:center;" title="change user"/>
        <input type="button" name="acutal user" id="au" value="actual user" style="text-align:center;" title="actual user"/>
       <a href="index.php" style="text-align:center;"><input type="button" name="acutal user" id="au" value="Suggest" style="text-align:center;" title="actual user"/></a></p>




    <input type="button" name="Valider" style="right:50px;position:absolute;top:190px;" value="valider" title="valider" id="valider">
    <!-- jQuery lib -->
<form action="./recherche.php" method="post" class="hidden" id="form">

      <input type="submit" value="Submit">
</form> 

</body>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- transform2d lib -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
         <script type="text/javascript" src="js/rateit.js/scripts/jquery.rateit.js"></script>

    <script type="text/javascript" src="js/jquery.transform2d.js"></script>
    <!-- jTinder lib -->
    <script type="text/javascript" src="js/jquery.jTinder.js"></script>
    <!-- jTinder initialization script -->
    <script type="text/javascript" src="js/main.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
 

    $('#btn-remove').click(function(){
        $('#select-to option:selected').each( function() {
            $('#select-from').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
 
});
   $( function() {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function camer(d){
    	j=0;
$('#select-to option').each(function(){

	if ($(this).attr("tmdb_id")==d.toString()) {
		return false;
		j=1;

	}
})

if (j==0) {return true;}

    }
    function extractLast( term ) {
      return split( term ).pop();
    }
    function arro(){
var arr =new Array();
    	$("#select-to option").each(function(){
    		idt=$(this).attr("tmdb_id");
    		imgt=$(this).attr("img");
    		titlet=$(this).attr("title");

arr.push({id:idt,img:imgt,title:titlet});
    	}) 
    	return arr; 
    	  }
    $("#valider").click(function(){
arr=arro();
console.log(arr);
$.post( {
          url: "begin_movie.php",
          data: {
            q: arr
          },
          success: function( data ) {
          	// data=$.parseJSON(data);
            // Handle 'no match' indicated by [ "" ] response
             console.log(data);

            if (data == 1){
            	window.location.reload();
            	console.log("reussit");
            }
          }
        } );
    });
    function addHidden(theForm, key, value) {
    // Create a hidden input element, and append it to the form:
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    theForm.prepend(input);
}

// Form reference:

  	$("#tags").autocomplete({
        source: function( request, response ) {
          $.post( {
          url: "search.php",
          data: {
            q: request.term
          },
          success: function( data ) {
          	console.log("dd");
          	data=$.parseJSON(data);
            // Handle 'no match' indicated by [ "" ] response
            response(data);
          }
        } );
      },
      select: function( event, ui ) {
      	id=ui.item.id;
      	title=ui.item.title;
      	if (camer(id)) {
      		item=ui.item;


      	$('#select-to').append("<option title='"+item.title+"'' img='"+item.img+"' tmdb_id="+id+" value='"+title+"'> "+ item.title + " <br> " + item.reals + "</option>");
      }
      }
        
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
    	console.log(item);
      return $( "<li>" )
        .append( "<div id="+item.id+" class='row' > <div class='col-lg-6'> <img src='https://image.tmdb.org/t/p/w45_and_h67_bestv2"+item.img+"'/></div><div class='col-lg-6'>" + item.title + "<br>" + item.reals + "</div></div>" )
        .appendTo( ul );
    };

    $("#nu").click(function(){
    	pseudo = prompt("Entrer un pseudo ?");
    	$.post( {
          url: "user.php",
          data: {
          	role: 1,
            pseudo: pseudo
          },
          success: function( data ) {
          	
if (data==-1) {
	alert("pseudo deja pris");
}else{
alert("ton id est: "+data);
var theForm = $("#form");
// Add data:
addHidden(theForm, 'id', data);
addHidden(theForm, 'pseudo', pseudo);
addHidden(theForm, 'idd', "<?php echo session_id(); ?>");

theForm.submit();

alert("user actuel: "+data["pseudo"]);
}
            // Handle 'no match' indicated by [ "" ] response
          }
        } );

    });
    $("#cu").click(function(){
id = prompt("Entrer un pseudo ?");
    	$.post( {
          url: "user.php",
          data: {
          	role: 2,
            id: id,
            idd: "<?php echo session_id(); ?>"
          },
          success: function( data ) {
          	
if (data==-1) {
	alert("pseudo inconnu");
}else{
	console.log(data);
	data=$.parseJSON(data);

	var theForm = $("#form");
// Add data:
addHidden(theForm, 'id', data["id"]);
addHidden(theForm, 'pseudo', data["pseudo"]);
addHidden(theForm, 'idd', "<?php echo session_id(); ?>");

theForm.submit();

alert("user actuel: "+data["pseudo"]);
}
            // Handle 'no match' indicated by [ "" ] response
          }
        } );
    });
    $("#au").click(function(){
    	
	data=<?php echo $_SESSION["id"]; ?>;
alert("user actuel: "+data);

            // Handle 'no match' indicated by [ "" ] response
          
    });
    });

  </script>
   
</body>
</html>
