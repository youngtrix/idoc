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
<html lang="en">
<head>
    <title>idoc - A simple and effective ebook creator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="idoc, technical team api document, development api document, api document, personal writing tool, make ebook, pubish electronic book" />
    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); }
    </script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="css/style2.css" type="text/css" media="all" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    <link href="css/google-latin-ext.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script async defer src="js/github-buttons.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
    <script src="js/modernizr.js"></script>
</head>
<body>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- banner -->
<div id="home" class="w3ls-banner">
    <!-- header -->
    <div class="header-w3layouts">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">travel</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h2><a class="navbar-brand" href="/"><i class="fa fa-angle-double-right w3-logo" aria-hidden="true"></i>Idoc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></h2>
                    <P>enjoy writing</P>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden"><a class="page-scroll" href="#page-top"></a>	</li>
                        <li><a href="./index.php#home">首页</a></li>
                        <li><a href="./index.php#about">关于</a></li>
                        <li><a href="javascript:promptModal();" data-toggle="modal" data-target="#myModal">联系</a></li>
                        <li style="padding-top:10px;padding-right:15px;"><a class="github-button" href="https://github.com/coderzheng/idoc/fork" data-icon="octicon-repo-forked" data-size="large" aria-label="Fork coderzheng/idoc on GitHub">Fork</a></li>
                        <?php
                        if ( !empty($username) ) {
                            echo '<li id="#projects" class="active"><a href="javascript:void(0);">我的项目</a></li>';
                        }
                        ?>
                        <?php
                        if ( empty($username) ) {
                            ?>
                            <li id="last">
                                <a href="admin/login.php" id="last_a">登录/注册</a>
                            </li>
                        <?php } else {?>
                            <li id="last">
                                <a href="admin/index.php" id="last_a"><?php echo $username;?></a>
                                <ul class="child-nav">
                                    <li><a href="admin/index.php">去后台</a>&nbsp;|&nbsp;<a href="./logout.php">退出</a></li>
                                </ul>
                            </li>
                        <?php }?>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container manual-body">
        <div class="row">
            <div class="manual-list">
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
    <div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">感谢您的建议.</h4>
                </div>
                <div class="modal-body">
                    <div class="agileits-w3layouts-info" style="font-size:18px;">
                        <p>对idoc的任何疑问或者建议, 都可发送至coderzheng@foxmail.com, ^^</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>© 2019 idoc. All Rights Reserved | Design by <a href="http://idoc.codespeaking.com/" target="=_blank"> idoc </a></p>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('li#last').hover(function(){
            $(this).children('ul.child-nav').show();
        }, function(){
            $(this).children('ul.child-nav').hide();
        });
    });

    function promptModal() {
        alert('对idoc的任何疑问或者建议, 都可发送至coderzheng@foxmail.com, ^^');
    }
</script>
</body>
</html>