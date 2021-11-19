<?php
require_once '../Libs/Product.php';
require_once '../Libs/Media.php';

//Create class Product and Media:
$product = new Product();
$media = new Media();

//func get count total images
function count_dir_files($dirname)
{
    $total_files=0;
    if(is_dir($dirname))
    {
        $dp=opendir($dirname);
        if($dp)
        {
            while(($filename=readdir($dp)) == true)
            {
                if(($filename !=".") && ($filename !=".."))
                {
                    $total_files++;
                }
            }
        }
    }
    return $total_files;
}

//get params:
if(isset($_POST)){
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
        $total_files_dir  = count_dir_files('../../Media/Images')+1;
        $len = count($_FILES['images']['name']);
        for ($i = 0; $i < $len; $i++)
            if($_FILES['images']['name'][$i] != ''){
                $file_name = "image-".($total_files_dir + $i).str_replace("image/",".",$_FILES['images']['type'][$i]);
                move_uploaded_file($_FILES['images']["tmp_name"][$i], "../../Media/Images/".$file_name);
                $media->addImages([":productId"=>$productId, ":url"=>$file_name, ":index"=>$i]);
            }
    }
}

header("Location: ../../Admin/Product_manage.php");
exit;
