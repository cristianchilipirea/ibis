#!/bin/bash

maxRunTime=300
submissionCheckersPath=data/checkers
rezultsPath=data/rezults
ssh_user=worker
keyFile=keys/ssh-privatekey

queuePath=$1
submissionName=$2
fullMachineName=$3

submissionType=$(echo $submissionName | cut -d'#' -f1)
submissionIdentifier=$(echo $submissionName | cut -d'#' -f2)
userName=$(echo $submissionName | cut -d'#' -f2 | cut -d'@' -f1)
timeStamp=$(echo $submissionName | cut -d'#' -f2 | cut -d'@' -f2)
machine=$(echo $fullMachineName | cut -f 1 -d "-")
port=$(echo $fullMachineName | cut -f 2 -d "-")

fullSubmissionPath="$queuePath/$fullMachineName/$submissionName"
fileDebug="$rezultsPath/$submissionType/$userName/$timeStamp/debug.txt"
sshCmd="ssh -i $keyFile -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -p $port $ssh_user@$machine"
scpCmd="scp -i $keyFile -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -P $port"

mkdir -p $rezultsPath/$submissionType/$userName/$timeStamp
echo "" > $fileDebug

echo "Running on $machine:$port" >> $fileDebug 2>&1

#upload submission
$sshCmd "mkdir $submissionName" >> $fileDebug 2>&1
$scpCmd $fullSubmissionPath $ssh_user@$machine:$submissionName/$submissionName >> $fileDebug 2>&1
$sshCmd "unzip -o $submissionName/$submissionName -d $submissionName" >> $fileDebug 2>&1

#upload checker
$scpCmd $submissionCheckersPath/$submissionType.zip $ssh_user@$machine:$submissionName/$submissionType.zip >> $fileDebug 2>&1
$sshCmd "unzip -o $submissionName/$submissionType.zip -d $submissionName" >> $fileDebug 2>&1

#run
$sshCmd "cd $submissionName; chmod 777 runAll.sh" >> $fileDebug 2>&1
fileRezults="$rezultsPath/$submissionType/$userName/$timeStamp/rezult.txt"
echo "" > $fileRezults
timeout $maxRunTime $sshCmd "cd $submissionName; ./runAll.sh" &> $fileRezults

#cleanup
$sshCmd "killall -9 runAll.sh" >> $fileDebug 2>&1
$sshCmd "killall -9 mpirun" >> $fileDebug 2>&1
$sshCmd "rm -R $submissionName" >> $fileDebug 2>&1

fullLongTermStoragePath="$rezultsPath/$submissionType/$userName/$timeStamp/$submissionName"
mv $fullSubmissionPath $fullLongTermStoragePath