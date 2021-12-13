<?php
require_once '../Libs/Cart.php';

//start session
session_start();

if(isset($_POST["submit"])){
    if(isset($_SESSION['cart']))
        $cart = $_SESSION['cart'];
    else $cart = [];

    $item = [
        'id' => $_POST['id'],
        'img' => $_POST['img'],
        'name' => $_POST['name'],
        'brand' => $_POST['brand'],
        'price' => $_POST['price'],
        'quantity' => $_POST['quantity']
    ];
    $cart = addItem($cart,$item);
    $_SESSION['cart'] = $cart;
}

header("Location: ../../Public/CartView.php");
exit;
