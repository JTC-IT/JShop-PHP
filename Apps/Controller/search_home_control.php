<?php
require_once '../Libs/Product.php';
require_once '../Libs/Media.php';

//get products
$product = new Product();

//create class media
$media = new Media();

//get params
$id = 0;
$key = '';
$start = 0;
if(isset($_GET['categoryId']))
    $id = $_GET['categoryId'];

if(isset($_GET['key']))
    $key = $_GET['key'];

if(isset($_GET['start']))
    $start = $_GET['start'];

//get result
$result = '';
$listProducts = $product->getProductsByPage($id,$key,$start,10);
if(isset($listProducts)) foreach ($listProducts as $p) {
        $result = $result."<div class='col-sm-4 pb-3 productItem'>
                <div class='card'>
                    <div class='card-body d-flex flex-column align-items-center'>
                        <img src='../Media/Images/".$media->getImage($p['Id'],0)[0]['Url']."'>
                        <div class='card-content d-flex flex-column align-items-center mt-3 justify-content-between'>
                            <div class='w-100'>
                                <div class='font-weight-bold text-center text-truncate'>".$p['Name']."</div>
                                <small class='text-primary text-center text-truncate'>Thương hiệu: ".$p['Brand']."</small>
                            </div>
                            <div class='w-100 mt-3 d-flex align-items-end justify-content-between'>
                                <strong class='text-danger'>".number_format($p['Price']).' đ'."</strong>
                                    <a class='btn btn-outline-success' href='./product_details.php?id=".$p['Id']."' role='button'>Xem</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>";
}

echo $result;