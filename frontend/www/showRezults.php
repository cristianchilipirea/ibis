<?php

$username = getUsername();
if(!isset($_GET['task']))
	exit("You need to add task to GET request");
$homeworkType = $_GET['task'];


function getTimeFromFile($fileName)
{
	$parts = explode('#', $fileName);
	$parts = explode('@', $parts[1]);
	return ((int)$parts[1]);
}

function getTimeFromDir($fileName)
{
	$parts = explode('@', $fileName);
	return ((int)$parts[1]);
}

function getIdFromTime($time)
{
	return (date("d-M-Y H:i:s", $time));
}
// uploads?
$uploadedFiles = scandir("data/uploads");
$uploadedFiles = array_diff($uploadedFiles, [".", ".."]);
foreach ($uploadedFiles as $uploadedFile) {
	if (strpos($uploadedFile, $username) === FALSE)
		continue;
	echo "<div class=\"alert alert-success\" role=\"alert\">Submission " . getIdFromTime(getTimeFromFile($uploadedFile)) . " is <strong>";
	$count = 0;
	foreach ($uploadedFiles as $fileAux) {
		if (getTimeFromFile($uploadedFile) > getTimeFromFile($fileAux))
			$count++;
	}
	echo $count . "</strong> in WAITING queue</div>";
}

$bufferedFiles = scandir("data/buffer");
$submissionsRunning = array();
foreach ($bufferedFiles as $bufferedFile) {
	if (strpos($bufferedFile, $username) !== FALSE) {
		array_push($submissionsRunning, getTimeFromFile($bufferedFile));
	}
}

$i = 0;

if (!is_dir("data/rezults/" . $homeworkType . "/" . $username))
	exit();
$homeworkDirs = scandir("data/rezults/" . $homeworkType . "/" . $username, SCANDIR_SORT_DESCENDING);
$homeworkDirs = array_diff($homeworkDirs, [".", ".."]);
foreach ($homeworkDirs as $homeworkDir) {
?>
	<div class="card">
		<div class="card-header" id="heading<?php echo $i; ?>">
			<h5 class="mb-0">
				<button class="btn <?php if (in_array($homeworkDir, $submissionsRunning)) echo "btn-success";
									else echo "btn-link"; ?>" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
					<?php echo "Submission " . getIdFromTime($homeworkDir) . " for " . $homeworkType;
					if (in_array($homeworkDir, $submissionsRunning)) echo " is RUNNING"; ?>
				</button>
			</h5>
		</div>

		<div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
			<div class="card-body">
				<?php
				$myfile = "data/rezults/" . $homeworkType . "/" . $username . "/" . $homeworkDir . "/rezult.txt";
				if(file_exists($myfile)) {
					$contents = file_get_contents($myfile);
					echo "<xmp>" . $contents . "</xmp>";
				} else 
					echo "<xmp>Results not yet ready!</xmp>";
				?>
			</div>
		</div>
	</div>
<?php
	$i++;
}
//}
?>