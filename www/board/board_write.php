<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');
require_once(__DIR__ . '/common.php');


$title = strip_tags($_POST['jtitle']);
$content = strip_tags($_POST['jcontent']);
$create = date("Y-m-d H:i:s");


if (!isset($_SESSION['idx']) && strlen($_SESSION['idx']) < 1) exit('<script>alert("로그인 후 이용 가능합니다."); location.href="/board/board_list.html";</script>');

$sql = 'select * from board_join where idx = ?';

if (!is_array($member = DB::conn()->select($sql, [$_SESSION['idx']]))) exit('<script>alert("회원정보를 확인할 수 없습니다."); location.href="/board/board_list.html";</script>');


$sql = 'insert into board_list (`jnum`, `jname`, `jtitle`, `jcontent`) 
        values (\'' . $member['idx'] . '\', \'' . $member['jname'] . '\', \'' . $title . '\', \'' . $content . '\')';


$result = DB::conn()->insert($sql);


exit('<script>alert("작성되었습니다."); location.href="/board/board_list.html";</script>');
?> 