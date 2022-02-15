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
			<a href="javascript:showAll();">SHOW</a>
			<?php

			$nextQuestion = 0;
			if (isset($_GET['newQuestion'])) {
				$nextQuestion = (int)($_GET['newQuestion']) + 1;
				$myfile = fopen("currentQuestion", "w");
				fwrite($myfile, $_GET['newQuestion']);
				fclose($myfile);
			}
			$questionNumber = file_get_contents('data/sphinx/currentQuestion');
			$currentQuestionText = file_get_contents('data/sphinx/currentQuestionText');
			$questionType = file_get_contents('data/sphinx/currentQuestionType');
			$files = glob("data/sphinx/" . $questionNumber . "/*");
			$fileCount = count($files);
			echo "(Au răspuns: " . $fileCount . ")";
			?>
			<a href="viewAnswer.php?newQuestion=<?php echo $nextQuestion ?>">NEXT QUESTION</a>
		</div>

		<?php
		echo "<div id=\"question\"><span>" . $currentQuestionText . "</span></div>";
		if (strcmp($questionType, "text") == 0) {


		?>

			<div style="margin: 3%; display: flex; width: 90%; height: 75%; flex-wrap:wrap" id="main">

				<?php
				$files = scandir("data/sphinx/" . $questionNumber);
				foreach ($files as $file) {
					if (strcmp($file, ".") == 0 or strcmp($file, "..") == 0)
						continue;
				?>
					<div style="border:solid; margin-top:10px; margin-left:10px; font-size: 30px;">
						<pre class="prettyprint" style="margin-bottom: 0; display:ruby; border: none;">
			<?php
					echo file_get_contents("data/sphinx/" . $questionNumber . "/" . $file);
			?>
			</pre>
					</div>
				<?php
				}
				?>
			</div>
		<?php
		} else {
			$givenAnswers = array(0, 0, 0, 0);

			$files = scandir("data/sphinx/" . $questionNumber);
			foreach ($files as $file) {
				if (strcmp($file, ".") == 0 or strcmp($file, "..") == 0)
					continue;
				if (is_numeric(file_get_contents("data/sphinx/" . $questionNumber . "/" . $file)))
					$givenAnswers[(int)file_get_contents("data/sphinx/" . $questionNumber . "/" . $file)]++;
			}
			$barLength = array();
		?>
			<div id="main">
				<?php
				$colors = array("primary", "secondary", "info", "success");
				for ($i = 0; $i < 4; $i++) {
					$barLength[$i] = (int)($givenAnswers[$i] * 100 / $fileCount);
				?>
					<div class="answer">
						<?php echo $answers[$i]; ?>
					</div>
					<div class="progress">
						<div class="progress-bar bg-<?php echo $colors[$i]; ?>" role="progressbar" style="width: <?php echo $barLength[$i]; ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
							<?php echo $givenAnswers[$i]; ?>
						</div>
					</div>

				<?php
				}
				?>
			</div>
		<?php
		}
		?>

	</div>
</body>