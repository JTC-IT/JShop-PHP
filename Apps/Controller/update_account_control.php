<?php
session_start();
require_once "../Libs/User.php";

if(!isset($_SESSION['user'])){
    header("Location: ./login_control.php");
    exit();
}

if(!isset($_POST['submit'])){
    unset($_SESSION['mess_phone']);
    unset($_SESSION['mess_name']);
    header("Location: ../../Public/Account.php");
    exit();
}

$check = true;
$name = '';
$phone = '';
$users = new User();
$user = $_SESSION['user'];

//check name
if(!isset($_POST['name']) || trim($_POST['name']) === ''){
    $check = false;
    $_SESSION['mess_name'] = 'Vui lòng nhập họ tên!';
}else $name = trim($_POST['name']);

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
    else if($users->checkPhone($phone,$user['Id'])){
        $check = false;
        $_SESSION['mess_phone'] = 'Số điện thoại đã được đăng ký!';
    }
}

//check success:
if($check){
    unset($_SESSION['mess_phone']);
    unset($_SESSION['mess_name']);

    $address = isset($_POST['address'])?trim($_POST['address']):'';

    $param = [':id'=>$user['Id']
        ,':name'=>$name
        , ':phone'=>$phone
        , ':address'=> $address
        , ':pass'=> $user['Password']
        , ':type'=>$user['Type']];

    if($users->updateUser($param)){
        $user['Name'] = $name;
        $user['Phone'] = $phone;
        $user['Address'] = $address;
        $_SESSION['user'] = $user;
        header("Location: ../../Public/Account.php?mes=2");
    }else {
        header("Location: ../../Public/Account.php");
    }
    exit();
}

header("Location: ../../Public/Account.php");