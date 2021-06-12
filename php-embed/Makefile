CC = gcc
# CFLAGS = -I/usr/local/include/php \
# 	-I/usr/local/include/php/main \
# 	-I/usr/local/include/php/Zend \
# 	-I/usr/local/include/php/TSRM \
# 	-Wall -g
# LDFLAGS = -L/usr/local/lib -lphp7 

# static
CFLAGS = -static -I/usr/src/php-7.2.34 \
	-I/usr/src/php-7.2.34/main \
	-I/usr/src/php-7.2.34/Zend \
	-I/usr/src/php-7.2.34/TSRM \
	-Wall -g
LDFLAGS = -L/usr/local/lib -L/usr/src/php-7.2.34/libs -lphp7 


console:
	$(CC) -o console console.c $(CFLAGS) $(LDFLAGS)

demo:
	$(CC) -o demo demo.c $(CFLAGS) $(LDFLAGS)

clean:
	- rm -rf demo console
