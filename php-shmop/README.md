# php-shmop

## build 
```
docker build -t heropoo/php-shmop .
```

## run 
```
docker run --rm -ti -v $PWD:/srv/www -p 8080:80 heropoo/php-shmop /bin/sh
```

## 共享内存
查看
```
ipcs -m
```

删除
```
ipcrm -m <shm_id>
```
