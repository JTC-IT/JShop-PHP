<?php

//start session
session_start();

if(isset($_POST["submit"])){
    $cart = [];

    if(isset($_SESSION['cart']))
        $cart = $_SESSION['cart'];

    $len_cart = count($cart);

    $cart[$len_cart] = $_POST;

    $_SESSION['cart'] = $cart;
}

header("Location: ../../Public/Cart.php");
exit;
