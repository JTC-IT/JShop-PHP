<?php
require_once '../Libs/Product.php';
require_once './add_media_control.php';

//Create class Product and Media:
$product = new Product();

$productId = 0;

//get params:
if(isset($_POST)
    && isset($_POST['name'])
    && isset($_POST['description'])
    && isset($_POST['brand'])
    && isset($_POST['model-year'])
    && isset($_POST['stock'])
    && isset($_POST['price'])
    && isset($_POST['category'])
){
    $p = [
        ':name' => $_POST['name']
        ,':description' => $_POST['description']
        ,':brand' => $_POST['brand']
        ,':model_Year' => $_POST['model-year']
        ,':stocks' => $_POST['stock']
        ,':price' => $_POST['price']
        ,':unit' => $_POST['unit']
        ,':categoryId' => $_POST['category']
    ];
    $productId = intval($product->addProduct($p));
    if(isset($_FILES) && $productId > 0){
        add_images($productId,$_FILES['images']);
    }
}

if($productId > 0)
    header("Location: ../../Admin/Product_manage.php?mess=1");
else header("Location: ../../Admin/Product_manage.php?mess=-1");
exit;
