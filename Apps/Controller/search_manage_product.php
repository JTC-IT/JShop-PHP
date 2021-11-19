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

$i = 1;
if(isset($listProducts)) foreach ($listProducts as $p) {
    $result = $result."<tr class='product-item'>
                <td>".$i++."</td>
                <td>".$p['Name']."</td>
                <td>".$p['Brand']."</td>
                <td>".$p['Stocks']."</td>
                <td>".number_format($p['Price'])."</td>
                <td>".$p['Date_Updated']."</td>
                <td>
                    <a href='./Update_Product.php?id=".$p['Id']."' class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>
                    <a href='#myModal' data-id='".$p['Id']."' class='delete' data-toggle='modal' title='Delete'><i class='material-icons'>&#xE872;</i></a>
                </td>
            </tr><br>";
}

echo $result;