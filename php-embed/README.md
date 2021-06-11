# php embed

## 解压php源代码
```
cd /usr/src/
xz -dk php.tar.xz
tar -xvf php.tar
cd php-7.2.34/
```

## 编译embed
```
./buildconf 
./configure --enable-embed --with-config-file-scan-dir=/usr/local/etc/php/conf.d --with-config-file-path=/usr/local/etc/php
make -j4
make install
```