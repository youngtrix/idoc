<?php

session_start();
require __DIR__ . '/../config.php';
require __DIR__ . '/../db.class.php';

if ( !empty($_POST) ) {
    $db = MySqlii::getInstance();
    $sql = 'SELECT password, id FROM ' . DB_PREFIX . 'user WHERE username="' . addslashes(trim($_POST['username'])) . '"';
    $query = $db->query($sql);
    $row = $db->fetch_array($query);
    if ( empty($row) ) {
        echo json_encode(['status'=> 'FAIL', 'code'=>-1, 'msg'=>'用户名不存在']);
        exit;
    }

    $md5_pass = $row['password'];
    $password = md5(PWD_SALT . trim($_POST['password']) . PWD_SALT);
    if ($md5_pass != $password) {
        echo json_encode(['status'=>'FAIL', 'code'=>-2, 'msg'=>'密码不正确']);
    } else {
        // 登录成功后, 首先更新一下最后用户表的last_login_time字段, 再获取用户自己的project_id列表存储在session中

        $_SESSION['user_id'] = $row['id'];
        $sql = "UPDATE " . DB_PREFIX . "user SET last_login_time='" . date('Y-m-d H:i:s') . "' WHERE id=" . $row['id'];
        $db->query($sql);

        $sql = "SELECT id FROM " . DB_PREFIX . "project WHERE user_id=" . $row['id'];
        $query = $db->query($sql);
        $pids = ',';
        while ( $row = $db->fetch_array($query) ) {
            $pids .= $row['id'] . ',';
        }
        $_SESSION['pids'] = $pids;
    }

    echo json_encode(['status'=>'SUCC', 'code'=>1, 'msg'=>'登录成功']);
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>idoc - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">idoc</h1>
        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" role="form" method="post" onsubmit="return false;" action="index.php">
            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="密码" required="">
            </div>
            <button type="button" onclick="login()" class="btn btn-primary block full-width m-b">登 录</button>
            <p class="text-muted text-center"> <a href="javascript:void(0);"><small>忘记密码了？</small></a> | <a href="register.php">注册一个新账号</a>
            </p>
        </form>
    </div>
</div>

<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>

<script type="text/javascript">
function login() {
    var username = $('#username').val();
    var password = $('#password').val();

    $.post('login.php', {'username':username, 'password':password}, function(res){
        if (res.code == 1) {
            alert('登录成功!');
            location.href = 'index.php';
        } else if(res.code == -2) {
            alert('登录失败,密码错误!')
        } else if (res.code == -1) {
            alert('登录失败,用户名不存在!');
        }
    }, 'json');
}
</script>

</body>

</html>
