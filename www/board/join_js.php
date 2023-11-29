<?php
ini_set( "display_errors", 1 );
error_reporting( E_ALL );

require_once(__DIR__ . '/Log.php');
require_once(__DIR__ . '/Pdo.php');
require_once(__DIR__ . '/common.php');


$id = $_POST['jid'];
$pass1 = $_POST['jpass1'];
$pass2 = $_POST['jpass2'];

if (!preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/",$id)) return _json('아이디는 영문+숫자로 입력해주세요.');

if (strlen($pass1) >= 8 && strlen($pass1) <=20) {
        
        if ($pass1 === $pass2) {

                $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
                $pass2 = password_hash($pass2, PASSWORD_DEFAULT);
                $name = $_POST['jname'];
                $address = $_POST['jaddress'];
                $code = $_POST['jcode'];
                $create = date("Y-m-d H:i:s");


                $sql = 'insert into board_join (jid, jpass1, jpass2, jname, jaddress, jcode, jcreate) 
                        values ("'.$id.'","'.$pass1.'","'.$pass2.'","'.$name.'","'.$address.'","'.$code.'","'.$create.'")';
                $result = DB::conn()->insert($sql);



        } else {
                return _json('비밀번호를 일치시켜주세요.');
        }

} else {
        return _json('비밀번호는 8~20자로 입력해주세요.');
}



return _json(false);

?>