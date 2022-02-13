<?php

if (isset($_POST['newWorker']) && $_POST['newWorker'] != "") {
	@mkdir("data/buffer/" . $_POST['newWorker'], 0700, true);
}

if (isset($_GET['deleteWorker']) && $_GET['deleteWorker'] != "") {
	rmdir("data/buffer/" . $_GET['deleteWorker']);
}

$files = scandir("data/buffer");
$files = array_diff($files, [".", ".."]);
foreach ($files as $file) {
	echo "<a href=\"?deleteWorker=$file\">$file</a><br>";
}
?>
<form action="" method="post" name="myForm">
	<input type="text" name="newWorker" placeholder="127.0.0.1-22" />
	<button>Add worker</button>
</form>