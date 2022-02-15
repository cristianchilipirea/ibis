<?php
$questionNumber = file_get_contents('data/sphinx/currentQuestion');
$questionTest = file_get_contents('data/sphinx/currentQuestionText');

if (isset($_GET['questionText'])) {
	file_put_contents('data/sphinx/currentQuestion', intval($questionNumber) + 1);
	mkdir('data/sphinx/' . (intval($questionNumber) + 1));
	file_put_contents('data/sphinx/' . (intval($questionNumber) + 1) . '/questionText', $_GET['questionText']);
	file_put_contents('data/sphinx/currentQuestionText', $_GET['questionText']);
}

?>

<html>

<head>
	<title>
		Curs AP
	</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/sphinx.css">
	<script src="js/textFill.js"></script>
	<script>
		$(function() {
			$('#nextQuestion').textfill({
				maxFontPixels: 500
			});
			$('#answerText').textfill({
				maxFontPixels: 500
			});
			$('#btn_answer').textfill({
				maxFontPixels: 500
			});
			$('#head').textfill({
				maxFontPixels: 500
			});
			$('.btn-ans').textfill({
				maxFontPixels: 500
			});
		});
	</script>
</head>

<body>
	<form action="" method="GET" id="question">
		<input type="text" class="form-control" form="question" name="questionText" style="height: 25vh; font-size: 15vh;"></input>
		<button type="Submit" form="question" id="btn_answer" class="btn btn-success btn-lg" style="margin-top: 10px; height: 25vh;" value="4">
			<span>
				Submite întrebare
			</span>
		</button>
	</form>
</body>

</html>