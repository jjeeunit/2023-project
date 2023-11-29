<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');

$idx = $_POST['idx'];

$idx_talk = $_POST['idx_talk'];

$talk = $_POST['jtalk'];
$parent = 0;
$depth = 1;
if (empty($_POST['jorder'])) {
        $_POST['jorder'] = 1;
} else {
        $_POST['jorder']++;
}
$order = $_POST['jorder'];



$sql = 'select * from board_join where idx = ?';

$result_join = DB::conn()->select($sql, [$_SESSION['idx']]);




$sql = 'select * from board_list where idx = ?';

$result_list = DB::conn()->select($sql, [$idx]);




// $sql = 'insert into board_talk (`jname`, `jtalk`, `jgno`, `jparent`, `jdepth`, `jorder`, `jgroup`)
//         values (\'' . $result_join['jname'] . '\', \'' . $talk . '\', \'' . $result['idx'] . '\', \'' . $parent . '\', \'' . $depth . '\', \'' . $order . '\', \'' . $result_list['idx'] . '\')';

// $result = DB::conn()->insertId($sql);



// $sql = 'insert into board_talk (`jname`, `jtalk`, `jgno`, `jparent`, `jdepth`, `jorder`, `jgroup`)
//         values (?,?,?,?,?,?,?)';

// $result = DB::conn()->insertId($sql, [$result_join['jname'], $talk, $result['idx'], $parent, $depth, $order, $result_list['idx']]);

// $result = DB::conn()->prevSql($sql, true);




$sql = 'insert into board_talk (`jname`, `jtalk`, `jgno`, `jparent`, `jdepth`, `jorder`, `jgroup`)
        values (?,?,?,?,?,?,?)';

$result = DB::conn()->insertId($sql, [$result_join['jname'], $talk, $idx_talk, $parent, $depth, $order, $result_list['idx']]);


// 코드바꿔
echo '<script>';
echo 'alert("댓글 작성되었습니다.");';
echo 'location.href="/board/board_talk.html?idx=' . $idx . '";';
echo '</script>';