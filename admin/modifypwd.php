<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.class.php';
require_once __DIR__ . '/check.php';

if ( !empty($_POST) ) {
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];
    $new_password = md5(PWD_SALT . $password . PWD_SALT);
    $db = MySqlii::getInstance();
    $sql = "UPDATE " . DB_PREFIX . "user SET password='" . $new_password . "' WHERE id=" . $user_id;
    $db->query($sql);
    echo json_encode(['status'=>'SUCC', 'msg'=>'操作成功!']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--360浏览器优先以webkit内核解析-->
    <title>读币网 - 修改密码</title>
    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-12">
                    <div class="middle-box text-center loginscreen   animated fadeInDown">
                        <h3>修改密码</h3>
                        <form class="m-t" role="form" onsubmit="return false;">
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码" required="">
                            </div>
                            <div class="form-group">
                                <input type="password" id="confirm_pwd" name="confirm_pwd" class="form-control" placeholder="请再次输入密码" required="">
                            </div>
                            <button type="button" id="btn" class="btn btn-primary block full-width m-b">确 定</button>
                            <!--<p class="text-muted text-center"><small>已经有账户了？</small><a href="login.html">点此登录</a>-->
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<script src="js/plugins/layer/layer.min.js"></script>
<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<!-- 自定义js -->
<script src="js/content.js"></script>
<!--flotdemo-->
<script type="text/javascript">
    $('#btn').click(function(){
        var password = $('#password').val();
        var confirm_pwd = $('#confirm_pwd').val();

        if ( $.trim(password) == '') {
            alert('密码不能为空!');
            $('#password').focus();
            return;
        }

        if (password != confirm_pwd) {
            alert('两次输入的密码不一致,请重新输入!');
            $('#password').focus();
            return;
        }

        $.post('modifypwd.php', {'password':password}, function(json){
            if (json.status == 'SUCC') {
                alert('操作成功!');
                history.go(0);
            }
        }, 'json');
    });
</script>
</body>

</html>
