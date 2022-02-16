<?php
include 'authorization.php';
if(!isAuthenticated())
	exit("You need to be logged in! If using the wiki you may need to do a force refresh (Ctrl+F5)");
if(!isset($_GET['task']))
	exit("You need to add task to GET request");

function getSafe($key) {
	if(isset($_GET[$key]))
		return $_GET[$key];
	if($key=='timestamp')
		return time();
	else
		return 1;
}
?>
<html>

<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="js.js"></script>
</head>

<body>
	<div class="accordion" id="accordionExample">
		If there are problems with the checker let us know about it using teams.
		<br>
		You may need to refresh to see results.
		<div style="display: flex;">
			<form id="submissionForm" class="form-inline" action="upload.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="task" value="<?php echo $_GET['task']; ?>">
				<input type="hidden" name="key" value="<?php echo getSafe('key'); ?>">
				<input type="hidden" name="username" value="<?php echo getUsername(); ?>">
				<input type="hidden" name="timestamp" value="<?php echo getSafe('timestamp'); ?>">

				<div class="form-group">
					<label for="submitHomework">Submite tema:</label>
					<input type="file" name="fileToUpload" id="fileToUpload" accept=".zip">
				</div>
				<input class="btn btn-primary" type="submit" value="Upload" name="submit">
			</form>
		</div>

		<?php
		include 'showRezults.php';
		?>
	</div>
</body>

</html>