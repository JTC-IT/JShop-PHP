<?php
session_start();
require_once "../Libs/User.php";

if(!isset($_POST['submit'])){
    unset($_SESSION['mess_phone']);
    unset($_SESSION['mess_pass']);
    unset($_SESSION['mess_name']);
    header("Location: ../../Admin/Update_User.php?id=".$_POST['id']);
    exit();
}

$check = true;
$name = '';
$phone = '';
$pass = '';
$users = new User();

//check name
if(!isset($_POST['name']) || trim($_POST['name']) === ''){
    $check = false;
    $_SESSION['mess_name'] = 'Vui lòng nhập họ tên!';
} else $name = trim($_POST['name']);

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
    else if($users->checkPhone($phone,$_POST['id'])){
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

//check success:
if($check){
    unset($_SESSION['mess_phone']);
    unset($_SESSION['mess_pass']);
    unset($_SESSION['mess_name']);

    $param = [':id'=>$_POST['id']
        ,':name'=>$name
        , ':phone'=>$phone
        , ':address'=>isset($_POST['address'])?trim($_POST['address']):NULL
        , ':pass'=>md5($pass)
        , ':type'=>(int)$_POST['type']];

    if($users->updateUser($param))
        header("Location: ../../Admin/User_manage.php?mess=2");
    else
        header("Location: ../../Admin/User_manage.php?mess=-2");
    exit();
}

header("Location: ../../Admin/Update_User.php?id=".$_POST['id']);