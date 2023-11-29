<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');
require_once(__DIR__ . '/common.php');



$idx_list = $_POST['idx_list'];
$idx_talk = $_POST['idx_talk'];
$talk3 = $_POST['jtalk3'];
$parent = $_POST['jparent'];
$depth = $_POST['jdepth'];
$update = date("Y-m-d H:i:s");
$order = $_POST['jorder'];



$sql_join = 'select * from board_join where idx = ?';
$result_join = DB::conn()->select($sql_join, [$_SESSION['idx']]);


$sql_list = 'select * from board_list where idx = ?';
$result_list = DB::conn()->select($sql_list, [$idx_list]);


$sql_talk = 'select * from board_talk where idx = ?';
$result_talk = DB::conn()->select($sql_talk, [$idx_talk]);
$result_talk['jdepth']++;


//jparent가 idx와 같으면 idx의 jdepth++ 로 update
$sql = 'update board_talk set jdepth = ?, jupdate = ? where jparent = ?';
$result = DB::conn()->update($sql, [$result_talk['jdepth'], $update, $result_talk['idx']]);



//order에서 idx를 특정해주면 그것만 update됨
$sql_order = 'update board_talk set jorder = jorder + 1 where jorder > ?';
$result_order = DB::conn()->update($sql_order, [$order]);
$order++;




$sql = 'insert into board_talk (`jname`, `jtalk`, `jparent`, `jdepth`, `jorder`, `jgroup`) 
        values (\'' . $result_join['jname'] . '\', \'' . $talk3 . '\', \'' . $parent . '\', \'' . $depth . '\', \'' . $order . '\', \'' . $result_list['idx'] . '\')';



$result = DB::conn()->insert($sql);
return _json(false);