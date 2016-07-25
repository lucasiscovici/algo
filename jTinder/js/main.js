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
        $.post( {
          url: "swipe.php",
          data: {
          	role: 3,
            id: item.attr("tmdb_id")
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
        $.post( {
          url: "swipe.php",
          data: {
          	role: 2,
            id: item.attr(tmdb_id)
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
        $("#modal1").attr("tmdb_id",item.attr("tmdb_id"));
        $("#modal1").attr("user",item.attr("user"));


    },
	animationRevertSpeed: 200,
	animationSpeed: 400,
	threshold: 1,
	likeSelector: '.like',
	dislikeSelector: '.dislike',
		seenSelector: '.seen'

});

$(".play").click(function(){
id=$(this).attr("id");
src="https://www.youtube.com/embed/"+id;
window.open(src);
});
$(".sv").click(function(){
id=$("#modal1").attr("tmdb_id");
user=$("#modal1").attr("user");
rate=$("#rateit5").rateit("value");
$.post( {
          url: "swipe.php",
          data: {
          	role: 1,
            id: id,
            note: rate
          },
          success: function( data ) {
          	
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