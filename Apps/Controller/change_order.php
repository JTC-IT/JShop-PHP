<?php
require_once "../Libs/Cart.php";
//start session
session_start();

if(isset($_GET['del'])){
    unset($_SESSION['cart']);
    header("Location: ../../Public/Home.php");
    exit;
}

$cart = [];

if (isset($_SESSION['cart']))
    $cart = $_SESSION['cart'];

if (isset($_GET["id"]) && isset($_GET["quantity"])) {
    if($_GET['quantity'] <= 0){
        $cart = removeItem($cart, $_GET["id"]);
        $_SESSION['cart'] = $cart;
        header("Location: ../../Public/CartView.php");
        exit;
    }
    else $cart = changeQuantity($cart, $_GET["id"], $_GET["quantity"]);

    $_SESSION['cart'] = $cart;

    echo getThanhTienByItem($cart, $_GET["id"]).";".getThanhTien($cart);
}


