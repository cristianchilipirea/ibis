<?php
$answers = array();
$students = array();
$an = 3;
if(isset($_GET["an"]))
        $an = $_GET["an"];
$handle = fopen("data/an".$an.".csv","r");
while ( ($data = fgetcsv($handle) ) !== FALSE ) {
        //echo $data[3];
        $students[] = $data[3];
        $studentGroups[$data[3]] = $data[2];
        $answers[$data[3]] = array();
}
$folders = scandir("data/sphinx/");
$folders = array_diff($folders,array(".","..","currentQuestion","currentQuestionText","currentQuestionType"));
//print_r($folders);
echo "Student,Group,NumAnswers";
foreach($folders as $folder) {
        $answerFiles = scandir("data/sphinx/".$folder);
        $answerFiles = array_diff($answerFiles, array(".",".."));
        $answerFiles = array_intersect($answerFiles, $students);
        $numAnswers[$folder] = count($answerFiles);
        foreach($answerFiles as $answerFile) {
                $answers[$answerFile][$folder] = file_get_contents("data/sphinx/".$folder."/".$answerFile);
        }
        if(empty($answerFiles))
                $removeFolders[] = $folder;
}

$folders = array_diff($folders, $removeFolders);
sort($students);
sort($folders,SORT_NUMERIC);
foreach($folders as $folder) {
        echo ",\"".$folder."\"";
}
echo "\n";
echo "-,-,-";
foreach($folders as $folder) {
        echo ",\"".$numAnswers[$folder]."\"";
}
echo "\n";
echo "-,-,-";
foreach($folders as $folder) {
        echo ",\"".file_get_contents("data/sphinx/".$folder."/questionText")."\"";
}
echo "\n";

foreach($students as $student) {
        echo $student.",".$studentGroups[$student].",";
        echo count($answers[$student]);
        foreach($folders as $folder) {
                if(isset($answers[$student][$folder]))
                        echo ",\"".$answers[$student][$folder]."\"";
                else
                        echo ",";
        }
        echo "\n";
}
//print_r($answers);
?>