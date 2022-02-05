#!/bin/bash

submissionCheckersPath=/home/data/checkers
rezultsPath=/home/data/rezults
queuePath=$1
submissionName=$2
maxRunTime=300

submissionType=$(echo $submissionName | cut -d'#' -f1)
submissionIdentifier=$(echo $submissionName | cut -d'#' -f2)
userName=$(echo $submissionName | cut -d'#' -f2 | cut -d'@' -f1)
timeStamp=$(echo $submissionName | cut -d'#' -f2 | cut -d'@' -f2)
machine=$(echo $3 | cut -f 1 -d "-")
port=$(echo $3 | cut -f 2 -d "-")
keyFile=/home/keys/ssh-privatekey
user=student

mkdir -p $rezultsPath/$submissionType/$userName/$timeStamp

sshCmd="ssh -i $keyFile -o StrictHostKeyChecking=no -p $port $user@$machine"
scpCmd="scp -i $keyFile -o StrictHostKeyChecking=no -P $port"

debugMsg="[DEBUG] executor $machine:$port "

#upload submission
echo -n $debugMsg
$sshCmd "mkdir $submissionName"
echo -n $debugMsg
$scpCmd $1$submissionName student@$machine:$submissionName/$submissionName
echo -n $debugMsg
$sshCmd "unzip -o $submissionName/$submissionName -d $submissionName"

#upload checker
echo -n $debugMsg
$scpCmd $submissionCheckersPath/$submissionType.zip student@$machine:$submissionName/$submissionType.zip
echo -n $debugMsg
$sshCmd "unzip -o $submissionName/$submissionType.zip -d $submissionName"

#run
echo -n $debugMsg
$sshCmd "cd $submissionName; chmod 777 runAll.sh"
timeout $maxRunTime $sshCmd "cd $submissionName; ./runAll.sh" &>> $rezultsPath/$submissionType/$userName/$timeStamp/rezult.txt
echo -n $debugMsg
$sshCmd "killall -9 runAll.sh"
echo -n $debugMsg
$sshCmd "killall -9 mpirun"

#cleanup
echo -n $debugMsg
$sshCmd "rm -R $submissionName"

mv $queuePath/$machine/$submissionName $rezultsPath/$submissionType/$userName/$timeStamp/$submissionName
