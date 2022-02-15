<?php
session_start();
include 'authorization.php';
if (!isAuthenticated())
	exit("NO ACESSS. You need to login again or refresh the page before you try to submit again.");

$questionNumber = file_get_contents('data/sphinx/currentQuestion');
$currentQuestionText = file_get_contents('data/sphinx/currentQuestionText');

if (!file_exists("data/sphinx/" . $questionNumber)) {
	mkdir($questionNumber);
}

if (isset($_GET['answer'])) {
	$myfile = fopen("data/sphinx/" . $questionNumber . "/" . $_GET['username'], "w");
	fwrite($myfile, $_GET['answer']);
	fclose($myfile);
	$_SESSION["lastQuestion"] = $questionNumber;
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
	<script src="js/sphinx.js"></script>
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
	<form style="display: none" action="" method="GET" id="question">
		<input type="hidden" name="question" value="<?php echo $questionNumber; ?>">
		<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
		<input type="hidden" name="timestamp" value="<?php echo $_GET['timestamp']; ?>">
		<input type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
	</form>
	<b>
		<?php
		if (isset($_SESSION["lastQuestion"]) && $_SESSION["lastQuestion"] == $questionNumber) {
		?>
			<button type="Submit" form="question" id="nextQuestion" class="btn btn-primary btn-lg">
				<div id="nextQuestionText">
					<span>
						NEXT QUESTION PLEASE!
					</span>
				</div>
			</button>
		<?php
		} else { ?>
			<div style="margin: 5%; display: inline-grid; width: 90%; height: 75%">
				<div id="head">
					<span>
						<?php echo $currentQuestionText; ?>
					</span>
				</div>
				<input type="text" class="form-control" form="question" name="answer" style="height: 25vh; font-size: 15vh;"></input>

				<button type="Submit" form="question" id="btn_answer" class="btn btn-success btn-lg" style="margin-top: 10px; height: 25vh;" value="4">
					<span>
						Submite răspuns
					</span>
				</button>
			</div>
		<?php } ?>
	</b>
</body>

</html>