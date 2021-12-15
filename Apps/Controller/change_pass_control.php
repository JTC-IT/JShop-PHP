<?php
session_start();
require_once "../Libs/User.php";

if(!isset($_SESSION['user'])){
    header("Location: ./login_control.php");
    exit();
}

if(!isset($_POST['submit'])){
    unset($_SESSION['mess_old_pass']);
    unset($_SESSION['mess_new_pass']);
    unset($_SESSION['mess_re_new_pass']);
    header("Location: ../../Public/Change_password.php");
    exit();
}

$check = true;
$old_pass = '';
$new_pass = '';
$users = new User();
$user = $_SESSION['user'];

// check old password
if(!isset($_POST['old_pass']) || trim($_POST['old_pass']) === ''){
    $check = false;
    $_SESSION['mess_old_pass'] = 'Vui lòng nhập mật khẩu cũ!';
}
else {
    $old_pass = md5(trim($_POST['old_pass']));
    if(strlen($old_pass) < 6 || strcmp($old_pass, $user['Password']) !== 0){
        $check = false;
        $_SESSION['mess_old_pass'] = 'Mật khẩu cũ không đúng!';
    }
}

// check new password
if(!isset($_POST['new_pass']) || trim($_POST['new_pass']) === ''){
    $check = false;
    $_SESSION['mess_new_pass'] = 'Vui lòng nhập mật khẩu mới!';
}
else {
    $new_pass = trim($_POST['new_pass']);
    if(strlen($new_pass) < 6){
        $check = false;
        $_SESSION['mess_new_pass'] = 'Mật khẩu phải ít nhất 6 ký tự!';
    }
}

//check re-password
if(!isset($_POST['re_new_pass']) || trim($_POST['re_new_pass']) === ''){
    $check = false;
    $_SESSION['mess_re_new_pass'] = 'Vui lòng nhập lại mật khẩu mới!';
}
else {
    $repass = trim($_POST['re_new_pass']);
    if(strcmp($new_pass,$repass) !== 0){
        $check = false;
        $_SESSION['mess_re_new_pass'] = 'Mật khẩu nhập lại không đúng!';
    }
}

//check success:
if($check){
    unset($_SESSION['mess_old_pass']);
    unset($_SESSION['mess_new_pass']);
    unset($_SESSION['mess_re_new_pass']);

    $new_pass = md5($new_pass);

    $param = [':id'=> $user['Id']
        ,':name'=> $user['Name']
        , ':phone'=> $user['Phone']
        , ':address'=> $user['Address']
        , ':pass'=> $new_pass
        , ':type'=>$user['Type']];

    if($users->updateUser($param)){
        $user['Password'] = $new_pass;
        $_SESSION['user'] = $user;
        header("Location: ../../Public/Account.php?mes=3");
        exit();
    }
}
header("Location: ../../Public/Change_password.php");