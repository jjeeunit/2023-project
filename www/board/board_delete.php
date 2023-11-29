<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');


$idx = isset($_GET['idx']) ? $_GET['idx'] : '';

$sql = 'select * from board_list where idx = ?';
$result = DB::conn()->select($sql, [$idx]);

if ($_SESSION['jname'] === $result['jname']) {

    $sql = 'delete from board_list where idx = ?';
    $result = DB::conn()->delete($sql, [$idx]);

    exit('<script>alert("삭제되었습니다."); location.href="/board/board_list.html";</script>');

} else {

    exit('<script>alert("본인만 삭제가능합니다. 삭제불가"); location.href="/board/board_list.html";</script>');

}


?>