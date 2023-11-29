<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');


$idx = isset($_POST['idx']) && ctype_digit($_POST['idx']) ? $_POST['idx'] : '';
$name = $_POST['jname'];
$title = $_POST['jtitle'];
$content = $_POST['jcontent'];
$update = date("Y-m-d H:i:s");


$sql = 'select * from board_list where idx = ?';
$result = DB::conn()->select($sql, [$idx]);

if ($_SESSION['jname'] === $result['jname']) {

    $sql = 'update board_list set jtitle = ?, jcontent = ?, jupdate = ? where idx = ?';
    $result = DB::conn()->update($sql, [$title, $content, $update, $idx]);

    exit('<script>alert("수정되었습니다."); location.href="/board/board_list.html";</script>');

} else {

    exit('<script>alert("본인만 수정가능합니다."); location.href="/board/board_list.html";</script>');

}
?>