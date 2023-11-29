<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');
require_once(__DIR__ . '/common.php');


$idx = $_POST['idx'];
$talk = $_POST['jtalk'];
$talk2 = $_POST['jtalk2'];
$update = date("Y-m-d H:i:s");


$sql = 'select * from board_talk where idx = ?';
$result = DB::conn()->select($sql, [$idx]);

if ($_SESSION['jname'] === $result['jname']) {

    $sql = 'update board_talk set jtalk = ?, jupdate = ? where idx = ?';
    $result = DB::conn()->update($sql, [$talk2, $update, $idx]);
    
} else {

    return _json('본인만 수정가능합니다.');
}

return _json(false);