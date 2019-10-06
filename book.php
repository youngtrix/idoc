<?php
require 'config.php';
require 'db.class.php';
require 'help.class.php';

$prid = intval($_GET['id']);
$article_id = (isset($_GET['aid']) ? intval($_GET['aid']) : 0);

if ( is_null($prid) || intval($prid)<=0 ) {
    emMsg('未传递合法的参数!');
}

$db = MySqlii::getInstance();
$sql_ = 'SELECT project_name, project_description, cover_img FROM ' . DB_PREFIX . 'project WHERE id=' . $prid;
$query_ = $db->query($sql_);
$row_ = $db->fetch_array($query_);
$project_description = $row_['project_description'];
$project_name = $row_['project_name'];

$sql = 'SELECT A.id, A.article_title, A.node_type, A.parent_id, A.project_id FROM ' . DB_PREFIX .'article as A WHERE A.project_id=' . $prid. ' ORDER BY A.order_id ASC, A.id ASC';
$query = $db->query($sql);
$rows = [];

while ( $row = $db->fetch_array($query) ) {
    $rows[] = ['id'=>$row['id'], 'node_type'=>$row['node_type'], 'article_title'=>$row['article_title'], 'parent_id'=>$row['parent_id'], 'project_id'=>$row['project_id']];
    if ( $article_id>0 && $row['id']==$article_id) {
        $article_title = $row['article_title'];
    }
}

if ( empty($rows) ) {
    emMsg('该项目作者尚未添加任何内容!');
    exit;
}

if ( !($article_id>0) ) {
    $article_id = $rows[0]['id'];
    $article_title = $rows[0]['article_title'];
}

$pids = [];
$pids = getParentID($article_id);

$tree = getTreeNode($rows);

$navMenu = getNavMenuOfTree($tree, $prid, $article_id, $pids);


?>
<html><head>
    <meta charset="UTF-8">
    <title><?php echo $article_title;?> · <?php echo $project_name;?> · idoc</title>
    <meta name="description" content="<?php echo $project_description;?>">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" data-react-helmet="true">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="css/reader.css">
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/marked.min.js"></script>
</head>
<body>
<div id="main">
    <div class="window-container">
        <!--<img src="https://cover.kancloud.cn/mutouzhang/gocookbook!middle" style="position: absolute; visibility: hidden;">-->
        <div>
            <div class="Loading__loading___1m_fZ">
                <div class="Loading__bar___21yOt" style="background: rgb(33, 186, 69); width: 0%; display: none;">
                    <div class="Loading__peg___3Y_28"></div>
                </div>
            </div>
            <div class="Loading__spinner___11Pm4">
                <div class="Loading__icon___3OOyu" style="display: none; border-color: rgb(33, 186, 69);"></div>
            </div>
        </div>
        <div class="window-body with-sidebar">
            <div class="sidebar">
                <div class="sidebar-header">
                    <a href="javascript:void(0);" data-no-pjax="true" class="title"><?php echo $project_name;?></a>
                    <!--<div class="search-form">
                        <div class="ui small fluid icon input"><input type="text" placeholder="请输入搜索关键词..."><i class="icon search"></i></div>
                    </div>
                    -->
                </div>
                <div class="sidebar-body">
                    <div class="catalog-body">
                        <?php
                        echo $navMenu;
                        ?>

                    </div>
                </div>
                <div class="sidebar-copyright">本文档使用 <a href="http://idoc.codespeaking.com" target="_blank">idoc</a> 构建</div>
            </div>
            <div class="workspace">
                <div class="article">
                    <div class="article-head">
                        <div class="left tools"><a class="item icon"><i class="icon align justify"></i></a></div>
                        <h1 id="article_title"></h1>
                        <!--
                        <div class="right tools">
                            <div role="listbox" aria-expanded="false" class="ui top right pointing dropdown item" tabindex="0">
                                <div class="text" role="alert" aria-live="polite"></div><i aria-hidden="true" class="share alternate icon"></i>
                                <div class="menu transition">
                                    <div role="option" class="item"><i aria-hidden="true" class="linkify icon"></i><span class="text">复制链接</span></div>
                                    <div role="option" class="item"><i aria-hidden="true" class="qq icon"></i><span class="text">腾讯QQ</span></div>
                                    <div role="option" class="item"><i aria-hidden="true" class="weibo icon"></i><span class="text">新浪微博</span></div>
                                    <div class="header"></div>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="article-body kancloud-markdown-body" id="article_content"></div>
                    <div class="article-navigation"><span class="prev"></span><span class="next"></span></div>
                    <div class="article-foot"></div>
                </div>
            </div>
            <script type="text/javascript">
                $.getJSON('get.php', {'aid': <?php echo $article_id;?>, 'id':<?php echo $_GET['id'];?>}, function(json){
                    content = json.content.replace(/\r\n/g, "\t\r\n");
                    $('#article_title').text(json.title);
                    $('span.prev').html(json.prev);
                    $('span.next').html(json.next);
                    document.getElementById('article_content').innerHTML = marked(content);
                });

                $("ul").delegate("li", "click", function(){
                    $(this).toggleClass("open");
                    $(this).children("i:first").toggleClass("right down");
                });

                $(".catalog-body > ul > li").hover( function() {
                    $(this).toggleClass("hover");
                });


                $(".catalog-body > ul > li > ul > li").hover(function(){
                    $(this).parent("ul").parent("li:first").toggleClass("hover");
                    $(this).toggleClass("hover");
                });


                $("i").click(function(){
                    var class_name = $(this).prop("class");
                    if (class_name=='icon align justify')
                    {
                        $('.window-body').toggleClass("with-sidebar");
                    }
                    return;
                })

            </script>
</body></html>