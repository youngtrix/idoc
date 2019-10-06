<?php

session_start();
require_once __DIR__ . '/../help.class.php';

if ( !isset($_SESSION['user_id']) || intval($_SESSION['user_id']) <=0 ) {
    emMsg('登录后才能继续操作!', 'login.php');
}