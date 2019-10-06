<?php
require 'config.php';
require 'db.class.php';

$aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ( $aid<=0 || $id<=0 ) {
    echo json_encode(['status'=>'FAIL', 'msg'=>'未传递合法的参数!']);
    exit;
}

$db = MySqlii::getInstance();
$sql = 'SELECT article_content, article_title FROM ' . DB_PREFIX . 'article WHERE id=' . $aid;
$query = $db->query($sql);
$row = $db->fetch_array($query);
$title = $row['article_title'];
$content = $row['article_content'];

$sql = 'SELECT A.id, A.article_title, A.project_id FROM ' . DB_PREFIX .'article as A WHERE A.project_id=' . $id. ' ORDER BY A.order_id ASC, A.id ASC';
$query = $db->query($sql);
$rows = [];

$i = 0;
$find = 0;
$prev_index = -1;
$next_index = -1;
while ( ($row = $db->fetch_array($query)) && ($find<=2) ) {
    $rows[$i] = ['id'=>$row['id'], 'article_title'=>$row['article_title']];
    if ($row['id'] == $aid) {
        $prev_index = $i - 1;
        $next_index = $i + 1;
        $find = 1;
    }
    if ($find) {
        $find++;
    }
    $i++;
}

$prev = '';
$next = '';

if ( isset($rows[$prev_index]) ) {
    $prev = '上一篇：<a href="book.php?id='.$id.'&aid='.$rows[$prev_index]['id'].'">'.$rows[$prev_index]['article_title'].'</a>';
}

if ( isset($rows[$next_index]) ) {
    $next = '下一篇：<a href="book.php?id=' . $id . '&aid=' . $rows[$next_index]['id'] . '">' . $rows[$next_index]['article_title'] . '</a>';
}

echo json_encode(['status'=>'SUCC', 'msg'=>'成功', 'content'=>$content, 'title'=>$title, 'prev'=>$prev, 'next'=>$next]);
exit;
