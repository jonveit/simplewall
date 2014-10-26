$(document).ready(function(){

	loadposts();
	
	$("#postfeed").sortable({
		update: function( event, ui ) {
			var posts = $('#postfeed').children("li");

			for (i = 0; i < posts.length; i++) {
				$.post('saveorder.php', { id: $(posts[i]).attr('value'), order: i + 100 });
			}	
		}
	});
	
	$('#addpost').submit( function() {
		
		var new_url = $("#addpost input[name=new-url]").val();
		
		if(new_url != '') {
			
			$("#newurl_field").val("");
			
			$.post('addpost.php', { url : new_url }, function( data ) {
				loadposts();
			});
		}
		return false;
	});
}); 

function loadposts() {
	$('#postfeed').load('returnposts.php', function() {
		
		$('button.deletepost').click( function() {
			var id = $(this).attr('value');
			var post = $(this).parent().parent();
			
			$.post('deletepost.php', { postid : id }, function() {
				post.fadeOut(800);
			});
		});
		
		$('button.editpost').click( function() {
			var id = $(this).attr('value');
			window.location.href = "editpost.php?postid=" + id;
		});
		
	});
}
/*

for (i = 0; i < posts.length; i++) {
    $.post('saveorder.php', { id: posts[i], order: i + 100 });
}
loadposts();
*/