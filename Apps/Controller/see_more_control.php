<?php
require_once '../Libs/Product.php';
require_once '../Libs/Media.php';

//get products
$product = new Product();

//create class media
$media = new Media();

function getImage($id, $index){
    global $media;
    $m = $media->getImage($id,$index);
    if(is_array($m))
        return "../Media/Images/".$m[0]['Url'];
    return "";
}

$result = '';

$param = ["start"=>isset($_GET['start'])?$_GET['start']:0, "limit"=>6];
$listProducts = $product->getProducts($param);
if(isset($listProducts)) foreach ($listProducts as $p) {
    $result = $result."<div class='col-sm-4 pb-3 productItem'>
                <div class='card'>
                    <div class='card-body d-flex flex-column align-items-center'>
                        <img src='".getImage($p['Id'],0)."' alt='Hình ảnh sản phẩm'>
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