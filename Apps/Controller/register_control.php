<?php
session_start();
require_once "../Libs/User.php";

if(!isset($_POST['name']) || $_POST['name'] === ''){
    session_destroy();
    header("Location: ../../Public/Register.php");
    exit();
}

$check = true;
$phone = '';
$pass = '';
$repass = '';
$users = new User();

//check phone
if(!isset($_POST['phone']) || trim($_POST['phone']) === ''){
    $check = false;
    $_SESSION['mess_phone'] = 'Vui lòng nhập số điện thoại!';
} else {
    $phone = trim($_POST['phone']);
    if(strlen($phone) != 10){
        $check = false;
        $_SESSION['mess_phone'] = 'Số điện thoại phải có 10 chữ số!';
    }
    else if($users->checkPhone($phone)){
        $check = false;
        $_SESSION['mess_phone'] = 'Số điện thoại đã được đăng ký!';
    }
}

// check password
if(!isset($_POST['pass']) || trim($_POST['pass']) === ''){
    $check = false;
    $_SESSION['mess_pass'] = 'Vui lòng nhập mật khẩu!';
}
else {
    $pass = trim($_POST['pass']);
    if(strlen($pass) < 6){
        $check = false;
        $_SESSION['mess_pass'] = 'Mật khẩu phải ít nhất 6 ký tự!';
    }
}

//check re-password
if(!isset($_POST['re-pass']) || trim($_POST['re-pass']) === ''){
    $check = false;
    $_SESSION['mess_repass'] = 'Vui lòng nhập lại mật khẩu!';
}
else {
    $repass = trim($_POST['re-pass']);
    if(strcmp($pass,$repass) !== 0){
        $check = false;
        $_SESSION['mess_repass'] = 'Mật khẩu nhập lại không đúng!';
    }
}

//check success:
if($check){
    unset($_SESSION['mess_phone']);
    unset($_SESSION['mess_pass']);
    unset($_SESSION['mess_repass']);

    $param = [':name'=>trim($_POST['name'])
        , ':phone'=>$phone
        , ':address'=>isset($_POST['address'])?trim($_POST['address']):''
        , ':pass'=>md5($pass)];

    if($users->addUser($param)){
        header("Location: ../../Public/Login.php?mes=1");
        exit();
    }else {
        header("Location: ../../Public/Register.php?mes=0");
        exit();
    }
}

header("Location: ../../Public/Register.php");