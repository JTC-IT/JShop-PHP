<?php
require_once "../Libs/Category.php";

if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0){
    $category = new Category();
    $category->deleteCategory($_GET['id']);
}

header("Location: ../../Admin/Category_manage.php");