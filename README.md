# idoc
A simple document creater site written by PHP

Let's try it! 

http://idoc.codespeaking.com

### 本地部署方法
将项目git clone到本地, 配置虚拟域名(不配置域名, 直接使用localhost也可以)

在根目录下创建config.php, 下面是一个样例：

```
<?php

date_default_timezone_set('PRC');

//mysql database address
define('DB_HOST','127.0.0.1');
define('DB_USER','XXXXX');
define('DB_PASSWD','XXXXX');
define('DB_NAME','idoc');

//database prefix
define('DB_PREFIX','id_');

define('PWD_SALT', '#20191008/iDoC^^');
//auth key
define('AUTH_KEY','zZQG6kMLKCf6gzzJUy$Zj^Un@mj52Hrx3365fde4a472decaa8f104b97717e125');
//cookie name
define('AUTH_COOKIE_NAME','EM_AUTHCOOKIE_BWlf5txDunNPpmsKCCpbve9ENTxdvnr2');
define('SITE_DOMAIN', 'localhost');
```

访问首页前, 先创建数据库, 并运行根目录下的schema.sql创建表。