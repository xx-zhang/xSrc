# Xsrc 1.2 

- [来源](https://security.tencent.com/opensource/detail/19)


## 搭建
- [Dockerfile](https://github.com/waytoking/docker-apache-php/blob/master/7.3/Dockerfile)
- `chmod -R 777 ./Application ./Public`


## 快速开始
```bash
docker-compose up -d 
```


## 单机搭建
```bash

docker run -itd \
	--restart=always \
	--name=xsrc \
	-e  TZ=Asia/Shanghai \
	-p 7780:80 \
	-v $(pwd)/xSRC_1.0.2:/var/www/app \
	registry.cn-beijing.aliyuncs.com/rapid7/apache-php:php73
```


## 数据库初始化
```bash

docker exec -t mysql mysql -uroot -ptest@1q2w2e4R -e 'CREATE DATABASE `xsrc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;'
docker exec -i mysql mysql -uroot -ptest@1q2w2e4R xsrc < ./DB/xsrc.sql

```