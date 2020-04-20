libcli_size.so: cli_size.c
	gcc -O2 -fPIC -shared -g cli_size.c -o libcli_size.so

run: libcli_size.so
	php cli_size.php

clean:
	- rm -rf *.so  *.dSYM
