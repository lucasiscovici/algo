/**
 * jTinder initialization
 */
$("#tinderslide").jTinder({
	// dislike callback
	onSwipe: function(item,nb_total,nb_rest){
console.log(item);
console.log(nb_total);
console.log(nb_rest);
	},
    onDislike: function (item) {
	    // set the status text
        $('#status').html('Dislike image ' + (item.index()+1));
       
        $.ajax( {
		method:"POST",
          url: "swipe.php",
          data: {
          	role: 3,
            id: item.attr("p_id")
     
          },
          success: function( data ) {
          	
if (data==-1) {
	console.log("pb swipe 3");
}else{
console.log("ton id est: "+data);
}
            // Handle 'no match' indicated by [ "" ] response
          }
        } );

    },
	// like callback
    onLike: function (item) {
	    // set the status text
        $('#status').html('Like image ' + (item.index()+1));
        title=item.attr("title");
                img=item.attr("img");

        $.ajax( {
		method:"POST",
          url: "swipe.php",
          data: {
          	role: 2,
            id: item.attr("p_id")
      
          },
          success: function( data ) {
          	
if (data==-1) {
	console.log("pb swipe 2");
}else{
console.log("ton id est: "+data);
}
            // Handle 'no match' indicated by [ "" ] response
          }
        } );
    },
    onSeen: function (item) {
	    // set the status text
        $('#status').html('Seen image ' + (item.index()+1));
        $("#modal1").modal("show");
        $("#modal1").attr("p_id",item.attr("p_id"));
        $("#modal1").attr("user",item.attr("user"));


    },
	animationRevertSpeed: 200,
	animationSpeed: 400,
	threshold: 1,
	likeSelector: '.like',
	dislikeSelector: '.dislike',
		seenSelector: '.seen'

});
$(".pane #nfo").click(function(){
p_id=$(this).parent().attr("p_id");
tmdb_id=$(this).parent().attr("tmdb_id");
ann=$(this).parent().find("#ann_ann").html();
title=$(this).parent().find("#title_title").html();
real=$(this).parent().find("#real_1").find("#real_real").html();
img=$(this).parent().find('.img').find("#img_img").attr("src");
$("#modal2 #title_modal").html(title);
$("#modal2 #ann_modal").html(ann);
$("#modal2 #real_modal").html(real);
$("#modal2 #img_modal").attr("src",img);
$.ajax( {
    method:"POST",
          url: "info.php",
          data: {
            role: 1,
            tmdb_id: tmdb_id
              },
          success: function( datad ) {
            console.log(datad);
            $('#genre_modal').html(datad);
            }
          });
$.ajax( {
    method:"POST",
          url: "info.php",
          data: {
            role: 2,
            tmdb_id: tmdb_id
              },
          success: function( datad ) {
            console.log(datad);
            $('#synop_modal').html(datad);
            }
          });
video=$(this).parent().find(".play");
if(video){
  $("#modal2 .play").attr("v_id",video.attr('v_id'));
}
$("#modal2").modal('show');

});
$(".play").click(function(){
id=$(this).attr("v_id");
src="https://www.youtube.com/embed/"+id;
window.open(src);
});
$(".sv").click(function(){
id=$("#modal1").attr("p_id");
user=$("#modal1").attr("user");
rate=$("#rateit5").rateit("value");
$.ajax( {
		method:"POST",
          url: "swipe.php",
          data: {
          	role: 1,
            id: id,
            note: rate
  },
          success: function( data ) {
          	$("#modal1").modal("hide");
if (data==-1) {
	console.log("pb swipe 1");
}else{
console.log("ton id est: "+data);

}
            // Handle 'no match' indicated by [ "" ] response
          }
        } );
	});
/**
 * Set button action to trigger jTinder like & dislike.
 */
$('.actions .like, .actions .dislike, .actions .seen').click(function(e){
	e.preventDefault();
	$("#tinderslide").jTinder($(this).attr('class'));
});