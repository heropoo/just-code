# php embed

## 解压php源代码
```
cd /usr/src/
xz -dk php.tar.xz
tar -xvf php.tar
cd php-7.2.34/
```

## 编译embed
```sh
./buildconf 
# ./configure --enable-embed --with-config-file-scan-dir=/usr/local/etc/php/conf.d --with-config-file-path=/usr/local/etc/php
#./configure --disable-all --enable-embed=static --enable-mysqlnd --enable-embedded-mysqli --enable-pcntl --enable-json --enable-posix 
./configure --disable-all --enable-embed=static --enable-json --enable-mbstring --enable-phar
make -j4
make install
```