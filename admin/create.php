<?php
require __DIR__ . '/check.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布快讯 - 后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <style type="text/css">
    #preview, .img, img {width:130px;height:130px;}
    #preview {border:1px solid #000;}

    span.red {color:#FF0000;}
    span.green {color:#009900;}
    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>发布项目 <small>发布一个新项目</small></h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form role="form">
                                <input type="text" id="project_name" class="form-control m-b" placeholder="请输入项目标题, 1-60个字" style="width:700px;" />
                                <textarea name="project_description" id="project_description" class="form-control m-b" style="width:700px;height:100px;" placeholder="项目描述(不超过255个字)"></textarea>
                                <!--
                                <br />
                                <div class="form-group">
                                    <div id="preview"></div>
                                    <label><br />上传封面：</label><input type="file" onchange="preview(this)" style="display:inline;" />
                                    <span>(*优质的封面有利于推荐,请使用清晰度较高的图片,最小尺寸260*160)</span>
                                </div>
                                -->
                                <br />
                                <input type="button" id="btn" name="btn" onclick="submitForm()" value="提交" />
                            </form>
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

<!-- 自定义js -->
<script src="js/content.js?v=1.0.0"></script>

<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="js/plugins/layer/laydate/laydate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });

    function preview(file) {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function(evt) {
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" name="cover" id="cover" />';
            }
            reader.readAsDataURL(file.files[0]);
        } else {
            prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }


    function submitForm() {
        var project_name = $('#project_name').val();
        //var is_imp = $("input[name='optionsRadios2']:checked").val();
        var project_description = $('#project_description').val();
        //var img = $('#cover').attr('src');
        //img_upload = (img==undefined?'':img);

        if ( $.trim(project_name) == '') {
            alert('项目名称不能为空!');
            return;
        }

        if ( $.trim(project_description) == '') {
            alert('项目描述不能为空!');
            return;
        }

        $.post('api.php', {'project_name':project_name, 'project_description':project_description, 'act':'create_project'}, function(res){
            if (res.pid > 0) {
                alert('添加成功!');
                history.go(0);
            } else {
                alert('添加失败!')
            }
        }, 'json');

        /*
        $.post('/backend/createflash', {'type':type, 'is_imp':is_imp, 'create_time':create_time, 'title':title,
                'content':content, 'comment':comment, 'cover':img_upload, 'cover2':img_upload2}, function(json){
                if (json.status>0) {
                    alert('添加成功!');
                    history.go(0);
                }
            }
        );
        */
    }
</script>
</body>
</html>
