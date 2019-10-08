<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../db.class.php';
require __DIR__ . '/../help.class.php';
require __DIR__ . '/check.php';

$db = MySqlii::getInstance();
$sql = 'SELECT A.*, B.username FROM ' . DB_PREFIX . 'project as A LEFT JOIN '. DB_PREFIX .'user as B ON(A.user_id=B.id) WHERE A.user_id=' . intval($_SESSION['user_id']) . ' order by A.id DESC';
$query = $db->query($sql);
$rows = [];
$nodesArr = [];
$i = 0;

while ( $row = $db->fetch_array($query) ) {
    $rows[] = $row;
    $nodesArr[$i] = getArticleInfo($row['id']);
    $i++;
}

function getArticleInfo($project_id) {
    global $db;
    $sql = 'SELECT id, article_title, parent_id, project_id FROM ' . DB_PREFIX .'article WHERE project_id=' . $project_id. ' ORDER BY order_id ASC, id ASC';
    $query = $db->query($sql);
    $rows = [];
    while ( $row = $db->fetch_array($query) ) {
        $rows[] = $row;
    }
    return $rows;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>idoc - hAdmin- 数据表格</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico">
    <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="css/plugins/jsTree/style.min.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>项目列表 <small>显示所有项目</small></h5>
                    <div class="ibox-tools"></div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th style="width:40px;">ID</th>
                            <th style="width:120px;">项目名称</th>
                            <th style="width:360px;">项目简介</th>
                            <th style="width:100px;">所属用户</th>
                            <th>目录结构(右键鼠标可进行操作)</th>
                            <th style="width:80px;">操作</th>
                            <th>是否公开</th>
                            <th style="width:126px;">创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $k=>$v) {
                            $is_open = '否';
                            if ($v['is_open'] == 1) {
                                $is_open = '是';
                            }
                            $str = '<tr class="gradeA"><td>' . $v['id'] . '</td><td>' . $v['project_name'] . '</td><td>' . $v['project_description'] . '</td><td>' . $v['username'] . '</td><td class="center"><div class="js_tree" id="js_tree_' . $v['id'] .'"><ul><li data-id="0" data-pid="0" data-projectid="' . $v['id'] . '">/';
                            $str .= getUlOfTree(getTreeNode($nodesArr[$k]));
                            /*
                            if ( empty($nodesArr[$k]) ) {
                                $str .= '</li></ul></div></td><td><a href="javascript:alert(\'至少需要一个子节点才能进行编辑!\');">编辑&nbsp;&nbsp;<a href="javascript:delete_project(' . $v['id']. ');">删除</a></td></tr>';
                            } else {
                                $str .= '</li></ul></div></td><td><a href="article.php?prid='.$v['id'].'">编辑</a>&nbsp;&nbsp;<a href="javascript:delete_project(' . $v['id']. ');">删除</a></td></tr>';
                            }
                            */
                            $str .= '</li></ul></div></td><td><a href="javascript:edit_project(' . $v['id'] . ');">编辑</a>&nbsp;&nbsp;<a href="javascript:delete_project(' . $v['id']. ');">删除</a></td><td class="center">' . $is_open .'</td><td class="center">' . $v['create_time'] . '</td></tr>';
                            echo $str;
                        }
                        ?>
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



<script src="js/plugins/jeditable/jquery.jeditable.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/jsTree/jstree.min.js"></script>
<style type="text/css">
    /*
    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }
    */
</style>
<!-- 自定义js -->
<script src="js/content.js?v=1.0.0"></script>

<!-- Page-Level Scripts -->
<script type="text/javascript">
    function delete_project(pid) {
        if ( !confirm('确定要进行此操作?') ) {
            return;
        }
        $.post('api.php', {'pid':pid, 'prid':pid, 'act':'delete_project'}, function(res){
            if (res.status == 'SUCC') {
                alert('操作成功!');
                history.go(0);
            } else {
                alert('操作失败!');
            }
        }, 'json');
    }

    function edit_project(pid) {
        $.post('api.php', {'pid':pid, 'act':'edit_project'}, function(res){
            if (res.node_count > 0) {
                location.href = 'article.php?prid=' + pid;
            } else {
                alert('至少需要一个子节点才能进行编辑!');
            }
        }, 'json');
    }

    $(document).ready(function () {
        $('.dataTables-example').dataTable({"order":[[0, 'desc']]});

        $('.js_tree').jstree({
            'core': {
                'check_callback': true,
                "animation": 0,

            },
            'plugins': ['types', 'dnd', 'contextmenu', 'state', 'types', 'wholerow'],
            'types': {
                'default': {
                    'icon': 'fa'
                },
                'html': {
                    'icon': 'fa'
                },
                'svg': {
                    'icon': 'fa'
                },
                'css': {
                    'icon': 'fa'
                },
                'img': {
                    'icon': 'fa'
                },
                'js': {
                    'icon': 'fa'
                }
            },
            "contextmenu": {
                "items": {
                    "create" : {
                        "label" : "新增",
                        "action" : function(obj) {
                            var inst = jQuery.jstree.reference(obj.reference);
                            var clickedNode = inst.get_node(obj.reference);
                            var index = clickedNode.id;
                            var did = $('#'+index).attr('data-id'); // 当前选中节点的文章ID
                            var prid = $('#'+index).attr('data-projectid'); // 当前选中节点的项目ID
                            var newNode = inst.create_node(obj.reference, {});
                            var ty = inst.get_type(obj.reference);
                            inst.set_type(newNode, ty);
                            inst.edit(newNode, {}, function(){
                                var title = $('#'+newNode+'_anchor').text();
                                $.post('api.php', {'title':title, 'did':did, 'prid':prid, 'act':'insert'}, function(res){
                                    if (res.status == 'SUCC') {
                                        alert('操作成功!');
                                        $('#'+newNode).attr({'data-id':res.did, 'data-pid':did, 'data-projectid':prid});
                                    } else {
                                        alert('操作失败, 请检查数据库连接是否正常!');
                                    }
                                }, 'json');
                            });
                            inst.open_node(obj.reference);
                        },
                    },

                    "rename" : {
                        "label" : "重命名",
                        "action" : function(obj) {
                            var inst = jQuery.jstree.reference(obj.reference);
                            var clickedNode = inst.get_node(obj.reference);
                            var index = clickedNode.id;
                            var txt = $('#'+index+'_anchor').text();
                            var did = $('#'+index).attr('data-id');
                            var prid = $('#'+index).attr('data-projectid'); // 当前选中节点的项目ID
                            if (txt == '/') {
                                alert('根节点不能重命名!');
                                return;
                            }
                            inst.edit(obj.reference, {}, function(){
                                var title = $('#'+index+'_anchor').text();
                                $.post('api.php', {'title':title, 'did':did, 'prid':prid, 'act':'update'}, function(res){
                                    if (res.status == 'SUCC') {
                                        alert('操作成功!');
                                    } else {
                                        alert('操作失败, 请检查数据库连接是否正常!');
                                    }
                                }, 'json');
                            });
                        }
                    },

                    "delete" : {
                        "label" : "删除",
                        "action" : function(obj) {
                            var inst = jQuery.jstree.reference(obj.reference);
                            var clickedNode = inst.get_node(obj.reference);
                            var index = clickedNode.id;
                            var txt = $('#'+index+'_anchor').text();
                            var did = $('#'+index).attr('data-id');
                            var prid = $('#'+index).attr('data-projectid'); // 当前选中节点的项目ID
                            if (txt == '/') {
                                alert('根节点不能删除!');
                                return;
                            }
                            if ( !confirm('确定要进行此操作!') ) {
                                return;
                            }
                            inst.delete_node(obj.reference);
                            $.post('api.php', {'did':did, 'prid':prid, 'act':'delete'}, function(res){
                                if (res.status == 'SUCC') {
                                    alert('操作成功!');
                                } else {
                                    alert('操作失败, 请检查数据库连接是否正常!');
                                }
                            }, 'json');
                        },
                    },

//                    "modify": {
//                        "label": "编辑",
//                        "action": function(obj) {
//                            var inst = jQuery.jstree.reference(obj.reference);
//                            var clickedNode = inst.get_node(obj.reference);
//                            var index = clickedNode.id;
//                            var txt = $('#'+index+'_anchor').text();
//                            var did = $('#'+index).attr('data-id');
//                            if (txt == '/') {
//                                alert('根节点不能编辑!');
//                                return;
//                            }
//                            location.href = 'article.php?did=' + did;
//                        }
//                    }
                }
            }
        });

    });
</script>
</body>
</html>
