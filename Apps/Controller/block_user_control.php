<?php

require_once "../Libs/User.php";

if(isset($_POST['id'])){
    $users = new User();
    $users->blockUser($_POST['id'],$_POST['blocked']);
}

header("Location: ../../Admin/User_manage.php");