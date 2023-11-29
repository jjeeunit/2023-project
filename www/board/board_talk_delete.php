<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');


$idx = isset($_GET['idx']) ? $_GET['idx'] : '';
$idx2 = isset($_GET['idx2']) ? $_GET['idx2'] : '';


$sql = 'select * from board_talk where idx = ?';
$result = DB::conn()->select($sql, [$idx2]);


if ($_SESSION['jname'] === $result['jname']) {
    
    $sql = 'delete from board_talk where idx = ?';
    $result = DB::conn()->delete($sql, [$idx2]);

    echo '<script>';
    echo 'alert("댓글이 삭제되었습니다.");';
    echo 'location.href="/board/board_talk.html?idx=' . $idx . '";';
    echo '</script>';

} else {
    
    echo '<script>';
    echo 'alert("본인만 삭제가능합니다. 삭제불가");';
    echo 'location.href="/board/board_talk.html?idx=' . $idx . '";';
    echo '</script>';

}

