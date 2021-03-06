#!/bin/bash

# have to be logged in as cristian (user that has acess to key for ssh to apd)
# nohup ./moveToBufferDaemon.sh > logMovetoBuffer.txt &

uploadPath=data/uploads
queuePath=data/buffer

while true; do
	for file in $(ls -tr $uploadPath/); do
		for machine in $(ls $queuePath/); do
			numRunning=$(ls $queuePath/$machine | wc -l)
			if [ $numRunning -ge 1 ]; then
				continue;
			fi
			mv $uploadPath/$file $queuePath/$machine
			echo $machine $queuePath/$machine $file &
			bash ./runHomework.sh $queuePath $file $machine &
			break;
		done;
	done;

	sleep 3
	date
done
