<?php
require_once "../Libs/Category.php";

if(isset($_POST['name']) && trim($_POST['name']) != ''){
    $category = new Category();
    if($category->addCategory([':name'=>$_POST['name'], ':parentId'=>$_POST['parent'] === 'NULL'?NULL:$_POST['parent']])){
        header("Location: ../../Admin/Category_manage.php?mess=1");
        exit();
    }
}

header("Location: ../../Admin/Category_manage.php?mess=-1");