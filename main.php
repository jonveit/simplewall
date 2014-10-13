<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Blog </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
</head>
<body>
	<div id="wrap">
		<button id="logout">Logout</button>
		<button id="display" onclick="window.location=display.php?user=$user">Display</button>
		
		<h2>Hello <?php echo $user; ?></h2>
		
		<form class="addpost" autocomplete="off">
			<input type="text" name="new-url" placeholder="enter a url...">
			<input type="submit" value="Add">
		</form>
		
		<ul id="blogfeed">
			
		</ul>
		
		<div id="messages"> 
			<?php echo $errorMessage; ?>
		</div>
	</div>
	
	<script>
	
	$(document).ready(function(){
		
		loadposts();
		
		function loadposts() {
			$("#blogfeed").html('');
			
			$("#blogfeed").load( 'returnposts.php', function() {
				
				$('button.deletepost').click( function() {
					var id = $(this).attr('value');
					var post = $(this).parent().parent();
					$.get('deletepost.php', { postid : id }, function() {
						post.fadeOut(800);
					});
				});
				
				$('button.editpost').click( function() {
					var id = $(this).attr('value');
					window.location.href = "editpost.php?postid=" + id;
				});
				
				$(function() {
					$("#blogfeed").sortable();
					$("#blogfeed").disableSelection();
				})
			});
		};
		
		
		
		$('#logout').click( function() {
			window.location.replace("logout.php");
		});
		
		$('#display').click( function() {
			window.location.href = "display.php?user=<?php echo $user; ?>";
		});
		
		$('.addpost').submit( function() {
			var new_url = $(".addpost input[name=new-url]").val();
			if(new_url != '') {
				$.get('addpost.php', { url : new_url }, function() {
					loadposts();
				});
			}
			return false;
		});
		
		
	});
	
	</script>
		
</body>
</html>

