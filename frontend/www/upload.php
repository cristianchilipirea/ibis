<?php
include 'authorization.php';

if(!isAuthenticated())
	exit("NO ACESSS. You need to login again or refresh the page before you try to submit again.");

function getHomeworkType($username, $time) {
	$homeworkTypes = array(
				array("users"=>"" , "startTime"=>1635960676, "endTime"=>1636952400, "name"=>"2021-ap-homework-1"),
				array("users"=>"" , "startTime"=>1617606000, "endTime"=>1619769600, "name"=>"sda-homework1"));

	foreach($homeworkTypes as $homeworkType) {
		if ($homeworkType["startTime"] < $time && $time < $homeworkType["endTime"]) {
			return $homeworkType["name"];
		}
	}
	exit("You are outside submission time");
}

$target_dir = "data/uploads/";
$homeworkType = $_POST['task'];
$username = getUsername();
$target_file = $target_dir.$homeworkType."#".$username."@".date('U')."#.zip";


$uploads_files = scandir($target_dir);
foreach($uploads_files as $upload_file) {
	if(strpos($upload_file, $username)!==FALSE)
		exit("ERROR You already have a submission in the waiting queue");
}

if (file_exists($target_file))
	exit("Sorry, file already exists.");

if ($_FILES["fileToUpload"]["size"] > 500000)
	exit("Sorry, your file is too large.");

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "zip") 
	exit("Sorry, only ZIP files are allowed.");


if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
	exit("Sorry, there was an error uploading your file.");

$urlpath = 'main.php?task='.$homeworkType.'&username='.$username.'&key='.$_POST['key'].'&timestamp='.$_POST['timestamp'];
header('Location: '.$urlpath);
echo "Go to: https://ibis.chilipirea.ro/".$urlpath;
?>