CC = gcc
CFLAGS = -I/usr/local/include/php \
	-I/usr/local/include/php/main \
	-I/usr/local/include/php/Zend \
	-I/usr/local/include/php/TSRM \
	-Wall -g
LDFLAGS = -L/usr/local/lib -lphp7 

all:
	$(CC) -o demo demo.c $(CFLAGS) $(LDFLAGS)

my:
	$(CC) -o my my.c $(CFLAGS) $(LDFLAGS)

clean:
	- rm -rf demo