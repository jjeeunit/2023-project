<?php 
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

session_start();

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');
require_once(__DIR__ . '/common.php');

$id = $_POST['jid'];
$pass1 = $_POST['jpass1'];

$sql = 'select * from board_join where jid = ?';
if (false === ($result = DB::conn()->select($sql,[$id]))) return _json('회원정보가 없습니다.');

if (password_verify($pass1, $result['jpass1'])) {

    $_SESSION['idx'] = $result['idx'];
    $_SESSION['jid'] = $result['jid'];
    $_SESSION['jname'] = $result['jname'];

} else {

    return _json('비밀번호가 다릅니다.');

}


return _json(false,['jname' => $result['jname']]);
?>