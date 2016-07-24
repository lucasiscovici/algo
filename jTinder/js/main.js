/**
 * jTinder initialization
 */
$("#tinderslide").jTinder({
	// dislike callback
    onDislike: function (item) {
	    // set the status text
        $('#status').html('Dislike image ' + (item.index()+1));

    },
	// like callback
    onLike: function (item) {
	    // set the status text
        $('#status').html('Like image ' + (item.index()+1));
    },
    onSeen: function (item) {
	    // set the status text
        $('#status').html('Seen image ' + (item.index()+1));
        $("#modal1").modal("show");
        $("#modal1").attr("tmdb_id",item.attr("id"));
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
console.log("value "+rate);

	});
/**
 * Set button action to trigger jTinder like & dislike.
 */
$('.actions .like, .actions .dislike, .actions .seen').click(function(e){
	e.preventDefault();
	$("#tinderslide").jTinder($(this).attr('class'));
});