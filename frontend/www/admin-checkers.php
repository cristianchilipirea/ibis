<?php

if (isset($_POST['newChecker']) && $_POST['newChecker'] != "") {
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/solution/in", 0700, true);
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/solution/outReference", 0700, true);
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/checker/out", 0700, true);
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/checker/tests/in", 0700, true);
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/checker/tests/out", 0700, true);
	@mkdir("data/checkers/" . $_POST['newChecker'] . "/checker/tests/outReference", 0700, true);
}

if (isset($_GET['checker']) && $_GET['checker'] != "") {
?>
	<a href=?>Back</a> <br>
<?php
	include "admin-checker.php";
	exit();
}

if (isset($_GET['deleteChecker']) && $_GET['deleteChecker'] != "") {
	system("rm -rf " . escapeshellarg("data/checkers/" . $_GET['deleteChecker']));
}

$files = scandir("data/checkers");
$files = array_diff($files, [".", ".."]);
foreach ($files as $file) {
	echo "<a href=\"?checker=$file\">$file</a> <a href=\"?deleteChecker=$file\">X</a><br>";
}
?>
<form action="" method="post" name="myForm">
	<input type="text" name="newChecker" placeholder="checkerName" />
	<button>Add checker</button>
</form>