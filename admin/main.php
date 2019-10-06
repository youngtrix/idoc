<?php
//require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../help.class.php';
require __DIR__ . '/check.php';

$s = getServerinfo();
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>首页 - 后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>首页</h5>
                    <div class="ibox-tools"></div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>系统版本：<?php echo $s[0];?></td>
                            <td>服务器操作系统：<?php echo $s[1];?></td>
                        </tr>
                        <tr>
                            <td>运行环境：<?php echo $s[2];?></td>
                            <td>PHP版本：<?php echo $s[3];?></td>
                        </tr>
                        <tr>
                            <td>Mysql版本：<?php echo $s[4];?></td>
                            <td>服务器IP：<?php echo $s[5];?></td>
                        </tr>
                        <tr>
                            <td>绝对路径：<?php echo $s[6];?></td>
                            <td>网站域名：<?php echo $s[7];?></td>
                        </tr>
                        <tr>
                            <td colspan="4">PHP已编译模块：<?php echo $s[8];?></td>
                        </tr>
                        <tr>
                            <td colspan="4">组件支持</td>
                        </tr>
                        <tr>
                            <td>FTP：<?php echo $s[9];?></td>
                            <td>XML解析：<?php echo $s[24];?></td>
                        </tr>
                        <tr>
                            <td>Session：<?php echo $s[25];?></td>
                            <td>Socket：<?php echo $s[10];?></td>
                        </tr>
                        <tr>
                            <td>Calendar：<?php echo $s[11];?></td>
                            <td>允许URL打开文件：<?php echo $s[12];?></td>
                        </tr>
                        <tr>
                            <td>GD库：<?php echo $s[13];?></td>
                            <td>压缩文件支持(Zlib)：<?php echo $s[14];?></td>
                        </tr>
                        <tr>
                            <td>IMAP电子邮件系统函数库：<?php echo $s[15];?></td>
                            <td>历法运算函数库：<?php echo $s[16];?></td>
                        </tr>
                        <tr>
                            <td>正则表达式函数库：<?php echo $s[17];?></td>
                            <td>WDDX支持：<?php echo $s[18];?></td>
                        </tr>
                        <tr>
                            <td>Iconv编码转换：<?php echo $s[19];?></td>
                            <td>mbstring：<?php echo $s[26];?></td>
                        </tr>
                        <tr>
                            <td>高精度数学运算：<?php echo $s[20];?></td>
                            <td>LDAP目录协议：<?php echo $s[21];?></td>
                        </tr>
                        <tr>
                            <td>Mcrypt加密处理：<?php echo $s[22];?></td>
                            <td>哈希计算：<?php echo $s[23];?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- 自定义js -->
<script src="js/content.js?v=1.0.0"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>

<!-- Peity -->
<script src="js/demo/peity-demo.js"></script>

<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>




</body>

</html>
