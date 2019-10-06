<?php
// 公共函数库

/*
// 根据数据库中查询到数据,获取节点树结构, 数组结构如下:
$nodesArr = [
    ['id' => 1, 'parent_id' => 0, 'name' => 'a'],
    ['id' => 2, 'parent_id' => 0, 'name' => 'b'],
    ['id' => 3, 'parent_id' => 1, 'name' => 'c'],
    ['id' => 4, 'parent_id' => 2, 'name' => 'd'],
    ['id' => 5, 'parent_id' => 6, 'name' => 'e'],
    ['id' => 6, 'parent_id' => 4, 'name' => 'f'],
    ['id' => 7, 'parent_id' => 6, 'name' => 'g'],
    ['id' => 8, 'parent_id' => 6, 'name' => 'h'],
    ['id' => 9, 'parent_id' => 10, 'name' => 'i'],
    ['id' => 10, 'parent_id' => 8, 'name' => 'j'],
];
*/

function getTreeNode($nodesArr, $parent_id = null) {
    $tree = array();
    $items = array();
    foreach ($nodesArr as $v) {
        if ( isset($items[$v['id']]['child']) ) {
            $tmp = $items[$v['id']]['child'];
            $items[$v['id']] = $v;
            $items[$v['id']]['child'] = $tmp;
        } else {
            $items[$v['id']] = $v;
        }
        if ($v['parent_id'] == 0) {
            $tree[] = &$items[$v['id']];
        } else {
            $items[$v['parent_id']]['child'][] = &$items[$v['id']];
        }
    }
    if ( !is_null($parent_id) && intval($parent_id)>0 ) {
        return isset($items[$parent_id]['child']) ? $items[$parent_id]['child'] : array();
    }
    return $tree;
}

// 根据节点树信息获取节点树的ul字符串
function getUlOfTree($tree) {
    $html = '<ul>';
    foreach ($tree as $v) {
        $html .= '<li data-id="' . $v['id'] . '" data-pid="' . $v['parent_id'] .'" data-projectid="' . $v['project_id'] .'">' . $v['article_title'];
        if ( isset($v['child']) ) {
            $html .= getUlOfTree($v['child']);
        } else {
            $html .= '</li>';
        }
    }
    $html .= '</ul>';
    return $html;
}

// 根据节点树信息获取节点树的select字符串
function getSelectOptionsOfTree($tree, $level=0, $article_id=0) {
    $html = '';
    foreach ($tree as $k=>$v) {
        if ($v['id'] == $article_id) {
            $html .= '<option value="' .$v['id'] . '" selected>' . getSpacesOfItem($level) . $v['article_title'] . '</option>';
        } else {
            $html .= '<option value="' .$v['id'] . '">' . getSpacesOfItem($level) . $v['article_title'] . '</option>';
        }

        if ( isset($v['child']) ) {
            $new_level = $level + 1;
            $html .= getSelectOptionsOfTree($v['child'], $new_level, $article_id);
        }
    }
    return $html;
}

// 根据节点树信息获取节点树的导航菜单
function getNavMenuOfTree($tree, $project_id=0, $article_id=0, $pids=[]) {
    $html = '<ul>';
    foreach ($tree as $v) {
        if ($v['node_type'] == 0) {
            $a_href = 'book.php?aid=' . $v['id'] . '&id=' . $project_id;
        } else {
            $a_href = "javascript:void(0);";
        }

        if ($v['id'] == $article_id) {
            $li_class = 'active';
        } else {
            $li_class = '';
        }

        if ( isset($v['child']) ) {
            $i_class = 'icon caret right';
        } else {
            $i_class = 'icon';
        }

        if ( in_array($v['id'], $pids) ) {
            $i_class = 'icon caret down';
            $li_class .= ' open';
        }

        if ( isset($v['child']) ) {
            $html .= '<li class="' . $li_class . '"><div class="wholerow"></div><i class="' . $i_class . '"></i><a class="text" href="' . $a_href .  '">' . $v['article_title'] . '</a>';
        } else {
            $html .= '<li class="' . $li_class . '"><div class="wholerow"></div><i class="' . $i_class . '"></i><a class="text" href="' . $a_href . '">' . $v['article_title'] . '</a>';
        }

        if ( isset($v['child']) ) {
            $html .= getNavMenuOfTree($v['child'], $v['project_id'], $article_id, $pids);
        } else {
            $html .= '</li>';
        }
    }
    $html .= '</ul>';
    return $html;
}

function getSpacesOfItem($level) {
    $str = '';
    while ($level>0) {
        $str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        $level--;
    }
    return $str;
}

function getParentID($article_id) {
    global $db;
    global $pids;
    $sql = 'SELECT parent_id FROM ' . DB_PREFIX . 'article WHERE id=' . $article_id;
    $query = $db->query($sql);
    $row = $db->fetch_array($query);
    $parent_id = $row['parent_id'];
    if ($parent_id == 0) {
        return [];
    } else {
        $pids[] = $parent_id;
        $pids = array_merge($pids, getParentID($parent_id));
    }
    return $pids;
}

// 检测函数支持
function isfun($funName = '')
{
    if (!$funName || trim($funName) == '' || preg_match('~[^a-z0-9\_]+~i', $funName, $tmp)) return '错误';
    return (false !== function_exists($funName)) ? '<font color="green">√</font>' : '<font color="red">×</font>';
}

//检测PHP设置参数
function show($varName)
{
    switch($result = get_cfg_var($varName))
    {
        case 0:
            return '<font color="red">×</font>';
            break;

        case 1:
            return '<font color="green">√</font>';
            break;

        default:
            return $result;
            break;
    }
}

// 获取服务器信息
function getServerinfo() {
    include_once 'config.php';
    $os = explode(" ", php_uname());
    // 操作系统
    $s1 = $os[0];
    // 内核版本
    $s2 = ('/' == DIRECTORY_SEPARATOR ? $os[2] : $os[1]);
    // 运行环境
    $s3 = $_SERVER['SERVER_SOFTWARE'];
    // PHP版本
    $s4 = PHP_VERSION;
    // mysql版本
    $s5 = '';
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD);
    $s5 = mysqli_get_server_info($link);
    // 服务器IP
    $s6 = gethostbyname($_SERVER['SERVER_NAME']);
    // 绝对路径
    $s7 = $_SERVER['DOCUMENT_ROOT'] ? str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) : str_replace('\\', '/', dirname(__FILE__));
    // 网站域名
    $s8 = SITE_DOMAIN;
    // 已编译模块检测
    $s9 = '';
    $able = get_loaded_extensions();
    foreach ($able as $key => $value) {
        if ($key!=0 && $key%26==0) {
            $s9 .= '<br />';
        }
        $s9 .= "$value&nbsp;&nbsp;";
    }
    // 组件支持
    $s10 = isfun("ftp_login");
    $s25 = isfun("xml_set_object");
    $s26 = isfun("session_start");
    $s27 = isfun("mb_eregi");
    $s11 = isfun("socket_accept");
    $s12 = isfun('cal_days_in_month');
    $s13 = show("allow_url_fopen");
    if (function_exists('gd_info')) {
        $gd_info = @gd_info();
        $s14 = $gd_info["GD Version"];
    } else {
        $s14 = '<font color="red">×</font>';
    }
    $s15 = isfun("gzclose");
    $s16 =  isfun("imap_close");
    $s17 = isfun("JDToGregorian");
    $s18 = isfun("preg_match");
    $s19 = isfun("wddx_add_vars");
    $s20 = isfun("iconv");
    $s21 = isfun("bcadd");
    $s22 = isfun("ldap_close");
    $s23 = isfun("mcrypt_cbc");
    $s24 = isfun("mhash_count");

//    for ($i=1; $i<=24; $i++) {
//        $v = 's' .$i;
//        echo ${$v} .  "<br />";
//    }

    return [$s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10, $s11, $s12, $s13, $s14, $s15, $s16, $s17, $s18, $s19, $s20, $s21, $s22, $s23, $s24, $s25, $s26, $s27];
}



/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false) {
    if ($msg == '404') {
        header("HTTP/1.1 404 Not Found");
    }
    echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
EOT;
    if ($isAutoGo) {
        echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
    }
    echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:650px;
	margin:60px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
EOT;
    if ($url != 'none') {
        echo '<p><a href="' . $url . '">&laquo;点击返回</a></p>';
    }
    echo <<<EOT
</div>
</body>
</html>
EOT;
    exit;
}