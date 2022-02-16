#!/bin/bash

address=http://ibis.chilipirea.ro/upload.php

files=`ls .| grep '.c\|in\|out'`
echo -e "Ading files \n $files \n to .zip arhive"
zip -r submission.zip $files

username=$(whoami)
task=$(pwd | cut -d'/' -f5)
timestamp=$(date +%s)
key=$(/home/getCode $timestamp | cut -d' ' -f1)

echo "Sending for user: $username Task: $task At time: $timestamp With key: $key"

curl -i $address \
	-F "task=$task" \
	-F "username=$username" \
	-F "timestamp=$timestamp" \
	-F "key=$key" \
	-F "fileToUpload=@submission.zip"
