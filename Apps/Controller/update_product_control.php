<?php
require_once '../Libs/Product.php';
require_once '../Libs/Media.php';

//Create class Product and Media:
$product = new Product();
$media = new Media();

if(isset($_POST) && isset($_POST['id'])) {
    $p = [
        ':id' => $_POST['id']
        ,':name' => $_POST['name']
        , ':description' => $_POST['description']
        , ':brand' => $_POST['brand']
        , ':model_Year' => $_POST['model-year']
        , ':stocks' => $_POST['stock']
        , ':price' => $_POST['price']
        , ':unit' => $_POST['unit']
        , ':categoryId' => $_POST['category']
        , ':cur_date' => date('Y-m-d H:i:s')
    ];
    $productId = intval($product->updateProduct($p));
}

header("Location: ../../Admin/Product_manage.php");
exit;