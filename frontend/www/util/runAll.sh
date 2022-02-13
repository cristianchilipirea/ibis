#!/bin/bash

function checkReturnCode {
	ret=$1
	if [ $ret == 124 ]
	then
		echo "ERROR: Program returned time out code (most likely timed out)"
		echo "ERROR: It is possible you have an infinte loop bug or a dead-lock"
		echo "ERROR: for dead-locks check with valgrind --tool=helgrind -s ./YOUR_PROGRAM"
	elif [ $ret == 127 ]
	then
		echo "ERROR: Program not found (maybe it did not compile)"
	elif [ $ret == 134 ]
	then
		echo "ERROR: Program returned Signal SIGABRT"
		echo "ERROR: maybe something wrong with malloc/free"
		echo "ERROR: check with valgrind --leak-check=full ./YOUR_PROGRAM"
	elif [ $ret == 139 ]
	then
		echo "ERROR: Program returned Signal SIGSEGV"
		echo "ERROR: Segfault - maybe something wrong with  malloc, free, pointer, overflow and so on"
		echo "ERROR: check with valgrind --leak-check=full ./YOUR_PROGRAM"
	elif [ $ret -gt 127 ]
	then
		echo "ERROR: Program ended with non-zero return code $ret"
		echo "ERROR: Does your program return 0?"
		echo "ERROR: Problems with system function-calls can also trigger this"
		echo "ERROR: in a terminal type 'trap -l' and see $(($ret-128)) to identify the error"
	elif [ $ret != 0 ]
	then
		echo "ERROR: Program ended with non-zero return code $ret."
		echo "ERROR: Does your program return 0?"
	fi
}

function runProgram {
	testName=$1
	cmd=$2
	diffCmd=$3
	outFile=$4
	maxRunTime=$5
	echo "Running test $testName"
	echo "0" > execTime

	#echo $cmd

	/usr/bin/time --quiet -f "%e" -o execTime timeout $maxRunTime $cmd  &> /dev/null
	ret=$?
	checkReturnCode $ret

	diffResult="FAILED"
	
	if [ ! -e $outFile ]
	then
		echo "ERROR: Output file does not exist"
	else
	 	$diffCmd &> /dev/null
	 	if [ $? != 0 ]
	 	then
	 		echo "ERROR: Output files differ"
	 	else
	 		diffResult="PASSED"
		fi
	fi
	execTime="`tail -n 1 execTime`"
	echo "Result test: $testName # File Comparison: $diffResult # Execution Time (where max is $maxRunTime): $execTime"
}

rmdir -rf out &> /dev/null
rmdir -rf tests/out &> /dev/null
mkdir out &> /dev/null
mkdir tests/out &> /dev/null

ls | grep Makefile | while read -r fileName; do make -f $fileName; done

{
    read
    while IFS=, read -r testName testCMD diffCMD inFile outFile refFile points timeOut isExecutable
    do 
		echo "=============================================================================="
        runProgram "$testName" "$testCMD" "$diffCMD" "$outFile" "$timeOut"
    done
} < toRun
