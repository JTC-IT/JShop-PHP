<?php
session_start();
require_once "../Libs/User.php";

if(!isset($_POST['login'])){
    session_destroy();
    header("Location: ../../Public/Login.php");
    exit();
}

$check = true;
$phone = '';
$pass = '';
$users = new User();

//check phone
if(!isset($_POST['phone']) || trim($_POST['phone']) === ''){
    $check = false;
    $_SESSION['mess_phone'] = 'Vui lòng nhập số điện thoại!';
} else {
    $phone = trim($_POST['phone']);
    if(strlen($phone) != 10){
        $check = false;
        $_SESSION['mess_phone'] = 'Số điện thoại không đúng!';
    }
    else if(!$users->checkPhone($phone)){
        $check = false;
        $_SESSION['mess_phone'] = 'Số điện thoại không đúng!';
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
        $_SESSION['mess_pass'] = 'Mật khẩu không đúng!';
    }
}

//check success:
if($check){
    $param = [':phone'=>$phone, ':pas'=>md5($pass)];

    $result = $users->getUser($param);
    if(count($result) > 0){
        unset($_SESSION['mess_phone']);
        unset($_SESSION['mess_pass']);
        $_SESSION['user'] = $result[0];
        if($result[0]['Type'] > 0)
            header("Location: ../../Admin/Product_manage.php");
        else header("Location: ../../Public/Home.php");
        exit();
    }else {
        $_SESSION['mess_pass'] = 'Mật khẩu không đúng!';
    }
}

$_SESSION['phone'] = $phone;
$_SESSION['pass'] = $pass;

header("Location: ../../Public/Login.php");