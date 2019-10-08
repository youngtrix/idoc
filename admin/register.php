<?php

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../help.class.php';
require_once __DIR__ . '/../db.class.php';

if ( !empty($_POST) ) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ( empty($username) || empty($password) ) {
        emMsg('用户名和密码不能为空!');
    }
    $new_password = md5(PWD_SALT . $password . PWD_SALT);
    $db = MySqlii::getInstance();
    $time = date('Y-m-d H:i:s');
    $sql = "INSERT IGNORE INTO " . DB_PREFIX . "user(username, password, create_time, update_time) VALUES('" . $username . "', '{$new_password}', '{$time}', '{$time}')";
    $query = $db->query($sql);
    $affect_rows = $db->affected_rows();
    if ($affect_rows > 0) {
        echo json_encode(['status'=>'SUCC', 'code'=>1, 'msg'=>'操作成功!']);
    } else {
        echo json_encode(['status'=>'FAIL', 'code'=>-1, 'msg'=>'操作失败!']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>idoc - 注册</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">idoc</h1>

        </div>
        <h3>欢迎注册 idoc</h3>
        <p>创建一个idoc新账户</p>
        <form class="m-t" role="form" action="login.html" onsubmit="return false;">
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control" placeholder="请输入用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="请输入密码" required="">
            </div>
            <div class="form-group">
                <input type="password" name="confirmpwd" id="confirmpwd" class="form-control" placeholder="请再次输入密码" required="">
            </div>
            <div class="form-group text-left">
                <!--
                <div class="checkbox i-checks">
                    <label class="no-padding">
                        <input type="checkbox"><i></i> 我同意注册协议</label>
                </div>
                -->
            </div>
            <button type="button" onclick="register()" class="btn btn-primary block full-width m-b">注 册</button>
            <p class="text-muted text-center"><small>已经有账户了？</small><a href="login.php">点此登录</a>
            </p>

        </form>
    </div>
</div>

<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });

    function register() {
        var username = $('#username').val();
        var password = $('#password').val();
        var confirmpwd = $('#confirmpwd').val();

        if (confirmpwd != password) {
            alert('密码输入不一致,请重试!');
            return;
        }

        $.post('register.php', {'username':username, 'password':password}, function(res){
            if (res.code == -1) {
                alert('用户名已存在,请更换用户名后重试!');
            } else if (res.code == 1) {
                alert('注册成功!');
                history.go(0);
            }
        }, 'json');
    }
</script>



</body>
</html>
