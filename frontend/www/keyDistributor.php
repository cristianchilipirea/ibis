<?php
include 'authorization.php';
header("Content-Type: text/plain");

if (!isset($_GET["keyType"]) || ($_GET["keyType"] != "key" && $_GET["keyType"] != "ppk"))
	exit("you need to add keyType=(key or ppk) to the GET request");

if (!isAuthenticated())
	exit("No access. Please login.");
if (file_exists("data/keys/" . $_GET["username"] . "." . $_GET["keyType"]))
	exit("Key not found for user " . $_GET["username"] . ".");

readfile("data/keys/" . $_GET["username"] . "." . $_GET["keyType"]);
