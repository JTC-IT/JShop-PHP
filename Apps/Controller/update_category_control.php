<?php
require_once "../Libs/Category.php";

if(isset($_POST['category-name']) && trim($_POST['category-name']) != ''){
    $category = new Category();
    if($category->updateCategory([':name'=>$_POST['category-name']
        , ':parentId'=>$_POST['category-parent'] === 'NULL'?NULL:$_POST['category-parent']
        , ':id'=>$_POST['category-id']])){
        header("Location: ../../Admin/Category_manage.php?mess=2");
        exit();
    }
}

header("Location: ../../Admin/Category_manage.php?mess=-2");