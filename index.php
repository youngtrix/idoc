<?php
session_start();
require 'config.php';
require 'db.class.php';

if ( !isset($_SESSION['user_id']) ) {
    $_SESSION['user_id'] = 0;
}

$db = MySqlii::getInstance();
$sql = 'SELECT A.*, B.username FROM ' . DB_PREFIX . 'project as A LEFT JOIN '. DB_PREFIX .'user as B ON(A.user_id=B.id) WHERE A.is_open=1 OR A.user_id=' . intval($_SESSION['user_id']) . ' order by A.id DESC';
$query = $db->query($sql);
$rows = [];

while ( $row = $db->fetch_array($query) ) {
    if ( empty($row['cover_img']) ) {
        $row['cover_img'] = 'images/default_cover.png';
    }
    $rows[] = $row;
}

$username = '';
if ( isset($_SESSION['user_id']) && intval($_SESSION['user_id'])>0 ) {
    $sql_ = 'SELECT username FROM ' . DB_PREFIX . 'user WHERE id=' . $_SESSION['user_id'];
    $query_ = $db->query($sql_);
    $row_ = $db->fetch_array($query_);
    $username = $row_['username'];
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>idoc - 在线文档管理</title>
    <meta name="author" content="codespeaking" />
    <meta name="site" content="http://codespeaking.com" />
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="manual-reader manual-container">
    <header class="navbar navbar-static-top navbar-fixed-top manual-header" role="banner">
        <div class="container">
            <div class="navbar-header col-sm-12 col-md-7 col-lg-6">
                <a href="/" class="navbar-brand" style="margin-left:-30px;font-weight:600;" title="idoc">
                    idoc
                </a>
                <!--
                <div class="searchbar pull-left visible-lg-inline-block visible-md-inline-block">
                    <form class="form-inline" action="/search" method="get">
                        <input class="form-control" name="keyword" type="search" style="width: 230px;" placeholder="请输入关键词..." value="">
                        <button class="search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                -->

                <div class="btn-group dropdown-menu-right pull-right slidebar visible-xs-inline-block visible-sm-inline-block">
                    <button class="btn btn-default dropdown-toggle hidden-lg" type="button" data-toggle="dropdown"><i class="fa fa-align-justify"></i></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="admin/login.php" title="用户登录">登录</a></li>
                    </ul>
                </div>
            </div>
            <nav class="navbar-collapse hidden-xs hidden-sm" role="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if ( !empty($username) ) {
                        echo '<li><a href="admin/index.php" title="后台">' . $username . '</a></li><li><a href="admin/logout.php" title="退出登录">退出</a></li>';
                    } else {
                        echo '<li><a href="admin/login.php" title="用户登录">登录</a></li><li><a href="admin/register.php" title="用户注册">注册</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container manual-body">
        <div class="row">
            <div class="manual-list">
                <!--
                <div class="list-item">
                    <dl class="manual-item-standard">
                        <dt>
                            <a href="/docs/help603" title="iWorker V6.0.3帮助手册（Web）-admin" target="_blank">
                                <img src="images/default_cover.png" class="cover" alt="iWorker V6.0.3帮助手册（Web）-admin">
                            </a>
                        </dt>
                        <dd>
                            <a href="/docs/help603" class="name" title="iWorker V6.0.3帮助手册（Web）-admin" target="_blank">iWorker V6.0.3帮助手册（Web）</a>
                        </dd>
                        <dd>
                            <span class="author">
                                <b class="text">作者</b>
                                <b class="text">-</b>
                                <b class="text">admin</b>
                            </span>
                        </dd>
                    </dl>
                </div>
                -->
                <?php
                foreach ($rows as $v) {
                    $style = '';
                    if ($v['is_open'] == 0) {
                        $style = "style='opacity:0.3'";
                    }
                    $htdoc = <<<EOF
    <div class="list-item" {$style}><dl class="manual-item-standard"><dt><a href="book.php?id={$v['id']}" title="{$v['project_name']}">
                <img src="{$v['cover_img']}" class="cover" alt="{$v['project_name']}">
            </a>
        </dt>
        <dd>
            <a href="book.php?id={$v['id']}" class="name" title="{$v['project_name']}">{$v['project_name']}</a>
        </dd>
        <dd>
            <span class="author">
                <b class="text">作者</b>
                <b class="text">:</b>
                <b class="text">{$v['username']}</b>
            </span>
        </dd>
    </dl>
</div>
EOF;
                    echo $htdoc;
                }?>
                <div class="clearfix"></div>
            </div>
            <nav class="pagination-container">
                <div class="clearfix"></div>
            </nav>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row text-center">
                <ul>
                    <li><a href="http://codespeaking.com">Author</a></li>
                    <li>&nbsp;·&nbsp;</li>
                    <li><a href="https://github.com/coderzheng/idoc/issues" target="_blank">意见反馈</a> </li>
                    <li>&nbsp;·&nbsp;</li>
                    <li><a href="https://github.com/coderzheng/idoc">Github</a> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="admin/js/jquery.min.js" type="text/javascript"></script>
<script src="admin/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>