#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(int argc, char *argv[])
{
	if (argc < 2)
		exit(1);

	char *salt = "SECRET_SALT_GOES_HERE";

	char cmd[1000];
	sprintf(cmd, "echo -n \"`whoami`%s%s\" | md5sum", salt, argv[2]);

	system(cmd);
}