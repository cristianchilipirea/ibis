<html>

<head>
	<title>
		Curs AP Răspunsuri
	</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
	<link rel="stylesheet" href="css/sphinx.css">
	<script src="js/sphinx.js"></script>
	<script>
		$(function() {
			$('#question').textfill({
				maxFontPixels: 500
			});
		});

		function showAll() {
			$('#main').css("visibility", "visible");
		}
	</script>
</head>

<body style="background-color:#fff;">
	<div id="all">
		<div id="controller">
			<a href="">REFRESH</a>
		</div>

		<div>
		<?php
		$answers = array();
		$handle = fopen("data/an3.csv");
		while ( ($data = fgetcsv($handle) ) !== FALSE ) {
			echo $data[3];
			$answers[$data[3]] = "sasa";
		}
		print_r($answers);
		?>
		</div>

	</div>
</body>