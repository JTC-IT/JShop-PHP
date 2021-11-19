<?php
require_once '../Libs/Product.php';
require_once '../Libs/Media.php';

//get id
$id = 0;
if(isset($_GET['id']))
    $id = $_GET['id'];
if($id > 0)
{
    //delete product
    $p = new Product();
    $p->deleteProduct($id);

    //delete media by product
    $m = new Media();
    $m->deleteImages($id);
}

header("Location: ../../Admin/Product_manage.php");
exit;