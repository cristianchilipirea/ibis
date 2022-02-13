<?php
if (!isset($_GET['checker']))
	exit("You need to set checker in GET request");
$checker = $_GET['checker'];

$checkerPath = "data/checkers/" . $checker;

if (isset($_POST['generateMakefile']) && $_POST['generateMakefile']) {
	$files = scandir($checkerPath . "/solution");
	foreach ($files as $file) {
		if (strpos($file, ".c") !== FALSE) {
			$fileBaseName = strtolower(pathinfo($file, PATHINFO_FILENAME));
			copy($checkerPath . "/solution/" . $file, $checkerPath . "/checker/" . $fileBaseName . "-sol.c");
			$fileContents = file_get_contents("util/Makefile");
			$fileContents = str_replace("homework", $fileBaseName, $fileContents);
			file_put_contents($checkerPath . "/checker/Makefile." . $fileBaseName, $fileContents);
		}
	}

	$files = scandir($checkerPath . "/checker");
	foreach ($files as $file) {
		if (strpos($file, ".c") !== FALSE) {
			$fileContents = file_get_contents("util/Makefile");
			$fileBaseName = strtolower(pathinfo($file, PATHINFO_FILENAME));
			$fileContents = str_replace("homework", $fileBaseName, $fileContents);
			file_put_contents($checkerPath . "/checker/Makefile." . $fileBaseName, $fileContents);
		}
	}
}

if (isset($_POST['generateRunner']) && $_POST['generateRunner']) {
	copy("util/runAll.sh", $checkerPath . "/checker/runAll.sh");
	$files = scandir($checkerPath . "/solution");
	$content = "testName,testCMD,diffCMD,inFile,outFile,refFile,points,timeOut,isExecutable\n";
	foreach ($files as $file) {
		if (strpos($file, ".c") === FALSE)
			continue;

		$programName = strtolower(pathinfo($file, PATHINFO_FILENAME));

		if (is_dir($checkerPath . "/solution/in/" . $programName)) {
			$inputFiles = scandir($checkerPath . "/solution/in/" . $programName);
			$inputFiles = array_diff($inputFiles, [".", ".."]);
			foreach ($inputFiles as $inputFile) {
				$inPath = "in/$programName/$inputFile";
				$outPath = "out/$programName-$inputFile";
				$outReferencePath = "outReference/$programName/$inputFile";
				$content .= "VerifyTestCases-" . $programName . "-" . $inputFile . ","
					. "./" . $programName . "-sol " . $inPath . " " . $outPath . ","
					. "diff " . $outPath . " " . $outReferencePath . ","
					. $inPath . ","
					. $outPath . ","
					. $outReferencePath . ","
					. "10,10,true\n";
			}
		}

		if (is_dir($checkerPath . "/checker/tests/in/" . $programName)) {
			$inputFiles = scandir($checkerPath . "/checker/tests/in/" . $programName);
			$inputFiles = array_diff($inputFiles, [".", ".."]);
			foreach ($inputFiles as $inputFile) {
				$inPath = "tests/in/$programName/$inputFile";
				$outPath = "tests/out/$programName-$inputFile";
				$outReferencePath = "tests/outReference/$programName/$inputFile";
				$content .= "VerifyProgram-" . $programName . "-" . $inputFile . ","
					. "./" . $programName . " " . $inPath . " " . $outPath . ","
					. "diff " . $outPath . " " . $outReferencePath . ","
					. $inPath . ","
					. $outPath . ","
					. $outReferencePath . ","
					. "10,10,true\n";
			}
		}
	}
	file_put_contents($checkerPath . "/checker/toRun", $content);
}

if (isset($_POST['generateZips']) && $_POST['generateZips']) {
	exec("rm " . $checkerPath . ".zip");
	exec("rm " . $checkerPath . "-solution.zip");
	exec("cd $checkerPath/checker && zip -r ../../" . $checker . ".zip .");
	exec("cd $checkerPath/solution && zip -r ../../" . $checker . "-solution.zip .");
	copy("data/checkers/$checker-solution.zip", "data/uploads/$checker#admin@" . time() . "#.zip");
}
?>

<iframe height=500 width=900 src="tinyfm-wrapper.php?p=<?php echo $checker ?>/solution" title="FileManager"></iframe>
<iframe height=500 width=900 src="tinyfm-wrapper.php?p=<?php echo $checker ?>/checker" title="FileManager"></iframe><br>
<form action="" method="post">
	<button type="submit" name="generateMakefile" value="true">Generate Makefile</button>
</form>
<form action="" method="post">
	<button type="submit" name="generateRunner" value="true">Generate Runner</button>
</form>
<form action="" method="post">
	<button type="submit" name="generateZips" value="true">Generate Zips</button>
</form>