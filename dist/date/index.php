<?php
	define("ROOT", "../../");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Assist - Date</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <?php
    	include_once ROOT.'dist/bootstrap.php';
    ?>
    
</head>

<body>
<div class="container">
	<form>
		<input type="text" placeholder="dd/mm/yyyy" class="date" autofocus  /><br />
		<input type="text" placeholder="dd/mm/yyyy" class="text" autofocus  /><br />
		<p id="error-message"></p>
	</form>
	<script src="script.js"></script>
	<script>
	$(".date").focusout(function(event){
		var date = new MyDate($(".date").val());
		if (date.isValid()){
			$("#error-message").html("Valid date");
		}
		else{
			$("#error-message").html("Invalid date");
		}
	});
	</script>
</div>
</body>
</html>
