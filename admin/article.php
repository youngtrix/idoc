<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../db.class.php';
require __DIR__ . '/../help.class.php';
require __DIR__ . '/check.php';

$prid = intval($_GET['prid']);
$db = MySqlii::getInstance();

$sql_ = 'SELECT project_name FROM ' . DB_PREFIX . 'project WHERE id=' . $prid;
$query_ = $db->query($sql_);
$row_ = $db->fetch_array($query_);
$project_name = $row_['project_name'];

$sql = 'SELECT id, article_title, article_content, node_type, parent_id, project_id FROM ' . DB_PREFIX .'article  WHERE project_id=' . $prid. ' ORDER BY order_id ASC, id ASC';
$query = $db->query($sql);
$rows = [];
$i = 0;
$did = 0;
$article_content = '';
$node_type = 0;
while ( $row = $db->fetch_array($query) ) {
    $rows[] = ['id'=>$row['id'], 'article_title'=>$row['article_title'], 'parent_id'=>$row['parent_id'], 'project_id'=>$row['project_id']];
    if ($i == 0) {
        $did = $row['id'];
        $article_content = $row['article_content'];
        $node_type = $row['node_type'];
    }
    $i++;
}

$optionHtml = getSelectOptionsOfTree(getTreeNode($rows), 0, $did);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8" />
    <title>Simple example - Editor.md examples</title>
    <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.5" rel="stylesheet">
    <link rel="stylesheet" href="editor.md/examples/css/style.css?v=2012331" />
    <link rel="stylesheet" href="editor.md/css/editormd.css?v=122133" />
    <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon" />
</head>
<body>
<div id="layout">
    <header>
        <span>当前位置：<?php echo $project_name;?></span>&nbsp;&nbsp;>&nbsp;&nbsp;<select id="articles"><?php echo $optionHtml; ?></select>&nbsp;&nbsp;
        设置<abbr title="当设置为目录节点时, 在前端页面无法浏览该节点的文章内容, 点击时表现为展开其子节点">节点类型</abbr>：<label style="font-weight:normal;"><input type="radio" <?php if($node_type==0){echo 'checked';} ?> value="0" id="optionsRadios1" name="node_type">文章节点</label>&nbsp;<label style="font-weight:normal;"><input type="radio" <?php if($node_type==1){echo 'checked';} ?> value="1" id="optionsRadios2" name="node_type">目录节点</label>
    </header>
    <div id="test-editormd">
        <textarea style="display:none;" id="md"><?php echo $article_content;?></textarea>
    </div>
    <div style="margin-left:1%;margin-top:3px;">
        <button type="button" class="btn-primary btn btn-xs" style="padding:2px 10px;color:#ffffff !important;background-color:#7266ba;border-color:#7266ba;" onclick="save_content()">保存修改</button>&nbsp;
        <button type="button" style="padding:2px 10px;color:#ffffff !important;background-color:#7266ba;border-color:#7266ba;" class="btn btn-primary btn-xs" onclick="goback()">返回</button>
    </div>
</div>
<script src="editor.md/examples/js/jquery.min.js"></script>
<script src="editor.md/editormd.js"></script>
<script type="text/javascript">
    var testEditor;

    $(function() {
        testEditor = editormd("test-editormd", {
            width   : "98%",
            height  : 640,
            syncScrolling : "single",
            path    : "editor.md/lib/",

            codeFold : true,
            //syncScrolling : false,
            saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
            searchReplace : true,
            //watch : false,                // 关闭实时预览
            //toolbar  : false,             //关闭工具栏
            //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
            emoji : true,
            taskList : true,
            tocm            : true,         // Using [TOCM]
            tex : true,                   // 开启科学公式TeX语言支持，默认关闭
            flowChart : true,             // 开启流程图支持，默认关闭
            sequenceDiagram : true,
            imageUpload : true,
            imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL : "./php/upload.php",
            onload : function() {
                console.log('onload', this);
                //this.fullscreen();
                //this.unwatch();
                //this.watch().fullscreen();

                //this.setMarkdown("#PHP");
                //this.width("100%");
                //this.height(480);
                //this.resize("100%", 640);
            }
        });
    });


    /*
    $(function() {

        $.get('http://dev.localhost.z/idoc/admin/editor.md/examples/test.md', function(md){
            //$.get('http://dev.localhost.z/test_55.php', function(md){
            testEditor = editormd("test-editormd", {
                width: "90%",
                height: 740,
                path : '../lib/',
                theme : "dark",
                previewTheme : "dark",
                editorTheme : "pastel-on-dark",
                markdown : md,
                codeFold : true,
                //syncScrolling : false,
                saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
                searchReplace : true,
                //watch : false,                // 关闭实时预览
                htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
                //toolbar  : false,             //关闭工具栏
                //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
                emoji : true,
                taskList : true,
                tocm            : true,         // Using [TOCM]
                tex : true,                   // 开启科学公式TeX语言支持，默认关闭
                flowChart : true,             // 开启流程图支持，默认关闭
                sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
                //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
                //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
                //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
                //dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
                //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                imageUpload : true,
                imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "./php/upload.php",
                onload : function() {
                    console.log('onload', this);
                    //this.fullscreen();
                    //this.unwatch();
                    //this.watch().fullscreen();

                    //this.setMarkdown("#PHP");
                    //this.width("100%");
                    //this.height(480);
                    //this.resize("100%", 640);
                }
            });
        });

        $("#goto-line-btn").bind("click", function(){
            testEditor.gotoLine(90);
        });

        $("#show-btn").bind('click', function(){
            testEditor.show();
        });

        $("#hide-btn").bind('click', function(){
            testEditor.hide();
        });

        $("#get-md-btn").bind('click', function(){
            //alert(testEditor.getMarkdown());
            //console.log(testEditor.getMarkdown());
            $.post('http://dev.localhost.z/test_55.php', {'contents':testEditor.getMarkdown()}, function(res){
                alert('OK');
            });
        });

        $("#get-html-btn").bind('click', function() {
            alert(testEditor.getHTML());
        });

        $("#watch-btn").bind('click', function() {
            testEditor.watch();
        });

        $("#unwatch-btn").bind('click', function() {
            testEditor.unwatch();
        });

        $("#preview-btn").bind('click', function() {
            testEditor.previewing();
        });

        $("#fullscreen-btn").bind('click', function() {
            testEditor.fullscreen();
        });

        $("#show-toolbar-btn").bind('click', function() {
            testEditor.showToolbar();
        });

        $("#close-toolbar-btn").bind('click', function() {
            testEditor.hideToolbar();
        });

        $("#toc-menu-btn").click(function(){
            testEditor.config({
                tocDropdown   : true,
                tocTitle      : "目录 Table of Contents",
            });
        });

        $("#toc-default-btn").click(function() {
            testEditor.config("tocDropdown", false);
        });
    });
    */
</script>
<script type="text/javascript">
$('#articles').change(function(){
    var val = $(this).val();
    $.post('api.php', {'did':val, 'act':'get_article_content'}, function(res){
        $('#md').val(res.content);
        testEditor = editormd("test-editormd", {
            width: "98%",
            height: 640,
            syncScrolling: "single",
            path: "editor.md/lib/",

            codeFold: true,
            //syncScrolling : false,
            saveHTMLToTextarea: true,    // 保存 HTML 到 Textarea
            searchReplace: true,
            //watch : false,                // 关闭实时预览
            //toolbar  : false,             //关闭工具栏
            //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
            emoji: true,
            taskList: true,
            tocm: true,         // Using [TOCM]
            tex: true,                   // 开启科学公式TeX语言支持，默认关闭
            flowChart: true,             // 开启流程图支持，默认关闭
            sequenceDiagram: true,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL: "./php/upload.php",
            onload: function () {
                //console.log('onload', this);
            }
        });

    }, 'json');
});

function save_content() {
    var did = $('#articles').val();
    var node_type = $("input[name='node_type']:checked").val();
    var article_content = testEditor.getMarkdown();
    $.post('api.php', {'did':did, 'node_type':node_type, 'article_content':article_content, 'act':'save_article_content'}, function(res){
        if (res.status == 'SUCC') {
            alert('保存成功!');
        } else {
            alert('保存失败!');
        }
    }, 'json');
}

function goback() {
    history.go(-1);
}

</script>
</body>
</html>