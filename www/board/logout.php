<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');

session_destroy();

exit('<script>alert("로그아웃 되었습니다."); location.href="/board/board_list.html";</script>');