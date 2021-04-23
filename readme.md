# Xsrc 1.2 

- [��Դ](https://security.tencent.com/opensource/detail/19)


## �
- [Dockerfile](https://github.com/waytoking/docker-apache-php/blob/master/7.3/Dockerfile)
- `chmod -R 777 ./Application ./Public`


## ���ٿ�ʼ
```bash
docker-compose up -d 
```


## �����
```bash

docker run -itd \
	--restart=always \
	--name=xsrc \
	-e  TZ=Asia/Shanghai \
	-p 7780:80 \
	-v $(pwd)/xSRC_1.0.2:/var/www/app \
	registry.cn-beijing.aliyuncs.com/rapid7/apache-php:php73
```


## ���ݿ��ʼ��
```bash

docker exec -t mysql mysql -uroot -ptest@1q2w2e4R -e 'CREATE DATABASE `xsrc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;'
docker exec -i mysql mysql -uroot -ptest@1q2w2e4R xsrc < ./DB/xsrc.sql

```