<?php
require_once '../Apps/Libs/Cart.php';

//start session
session_start();

if(isset($_SESSION['cart']))
    $cart = $_SESSION['cart'];

else $cart = [];

$check = getTotalQuantity($cart) > 0;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JShop</title>
    <link rel="icon" href="../Media/Images/icon_jshop.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!--Jquery--->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- IonIcon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <!--Style-->
    <link rel="stylesheet" href="../Media/CSS/home_style.css">
    <link rel="stylesheet" href="../Media/CSS/cart_style.css">
</head>
<body>
<!-- Header -->
<div class="header-top">
    <!--Left elements-->

    <!--Right elements-->
    <ul class="navbar-nav d-flex flex-row-reverse">
        <!-- Right elements -->
        <li class="nav-item mr-4 font-weight-bold"><a href="#" class="nav-link">ĐĂNG NHẬP</a></li>
        <li class="nav-item mr-4 font-weight-bold"><a href="#" class="nav-link">ĐĂNG KÝ</a></li>
    </ul>
</div>
<nav class="navbar navbar-expand-lg sticky-top bg-secondary">
    <div class="container">
        <div class="w-100 d-flex justify-content-between">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="./Home.php">
                <img src="../Media/Images/logo_shop.png" height="55" alt="JShop" />
            </a>
            <!-- Right elements -->
            <div class="d-flex justify-content-between align-items-center w-50">
                <div class="has-search w-75 h-auto d-flex align-items-center">
                    <ion-icon name="search" class="form-control-feedback" size="small"></ion-icon>
                    <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm" onkeyup="searchByKey(this.value,1)">
                </div>
                <a class="nav-link d-flex align-items-center link-cart" href="CartView.php">
                    <span id="badge-cart" class="badge rounded-pill bg-danger text-light"><?php if($check) echo getTotalQuantity($cart)?></span>
                    <ion-icon name="cart-outline"></ion-icon>
                </a>
            </div>
        </div>
    </div>
</nav>
<!--Body-->
<div class="container" id="body">
    <div class="row">
        <!-- header-->
        <div class="mt-3 mb-2 w-100 border-bottom">
			<h4 class="font-weight-bold">GIỎ HÀNG CỦA TÔI</h4>
        </div>
        <!-- Shopping Cart-->
        <div class="table-responsive shopping-cart">
            <table class="table bg-light">
                <thead>
                <tr class="table-active">
                    <th>Sản Phẩm</th>
                    <th class="text-center">S.Lượng</th>
                    <th class="text-center">Thành Tiền</th>
                    <th class="text-center">
                        <button id="btn-cleanCart" class="btn btn-sm btn-outline-danger"
                                onclick="document.getElementById('confirmClean').style.display='block'">
                            Xóa tất cả</button>
                    </th>
                </tr>
                </thead>
                <tbody id="cart-body">
                <?php if($check)
                    foreach ($cart as $item){?>
                        <tr class="cart-item">
                            <td>
                                <div class="d-flex">
                                    <a class="product-thumb" href="product_details.php?id=<?=$item['id']?>">
                                        <img src="<?='../Media/Images/'.$item['img']?>" alt="Book" height="65" class="border border-dark">
                                    </a>
                                    <div class="ml-2 d-flex flex-column" style="width: 30rem">
                                        <span class="font-weight-bold">
                                            <a href="product_details.php?id=<?=$item['id']?>" class="d-block text-truncate text-black">
                                                <?=$item['name']?>
                                            </a>
                                        </span>
                                        <span class="d-block text-truncate"><?=$item['brand']?></span>
                                        <span class="text-warning text-lg"><?=number_format($item['price'])." đ"?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-group">
                                    <select class="form-control" onchange="changeAmount(this.value,<?=$item['id']?>)">
                                        <?php
                                        for ($i = 1; $i < 10; $i++){
                                            echo "<option value='$i' ";
                                            if($i == $item['quantity'])
                                                echo "selected";
                                            echo ">$i</option>";
                                        } ?>
                                    </select>
                                </div>
                            </td>
                            <td id="price_<?=$item['id']?>" class="text-center text-lg text-warning font-weight-bold"><?=number_format($item['price']*$item['quantity'])." đ"?></td>
                            <td class="text-center">
                                <a role="button" class="btn btn-light text-danger"
                                        href="../Apps/Controller/change_order.php?id=<?=$item['id']?>&quantity=0">
                                    <ion-icon name="trash"></ion-icon>
                                </a>
                            </td>
                        </tr>
                    <?php } else{?>
                    <!-- Alert-->
                    <tr>
                        <td colspan="4">
                            <div class="alert alert-info w-100 h-100 text-center" role="alert">
                                <span>Giỏ hàng trống !</span>
                            </div>
                        </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div class="border-top border-dark w-100">
            <div class="float-right p-3">
                Thành tiền:
                <h3 id="sumPay" class="d-inline font-weight-bold text-warning">
                    <?php if($check) echo getThanhTien($cart);
                        else echo "0 đ";
                    ?>
                </h3>
            </div>
        </div>
        <div class="border-top border-dark w-100 p-3">
            <div class="float-left">
                <a class="btn btn-outline-primary" href="Home.php">
                    <i class="icon-arrow-left"></i>Tiếp tục mua</a>
            </div>
            <div class="float-right">
                <?php if($check){?>
                    <button type="button"
                            id="btn-payCart"
                            class="btn btn-success"
                            onclick="document.getElementById('modalConfirmOrder').style.display='block'">
                        Đặt mua ngay
                    </button>
                <?php }?>
            </div>
        </div>
    </div>

    <!-- Modal confirm Order -->
    <div id="modalConfirmOrder" class="modal">
		<span
            onclick="document.getElementById('modalConfirmOrder').style.display='none'"
            class="close" title="Close Modal">×</span>
        <div class="modal-content">
            <h2>Hoàn tất đặt hàng</h2>
            <p>Đặt tất cả các sản phẩm trong giỏ hàng của bạn.</p>
            <div class="d-flex justify-content-between">
                <button type="button"
                        onclick="document.getElementById('modalConfirmOrder').style.display='none'"
                        class="btn btn-outline-secondary">Hủy bỏ</button>
                <a href="#" role="button" class="btn btn-success text-light">Đặt hàng</a>
            </div>
        </div>
    </div>

    <!-- Modal confirm clear cart -->
    <div id="confirmClean" class="modal">
		<span
            onclick="document.getElementById('confirmClean').style.display='none'"
            class="close" title="Close Modal">×</span>
        <div class="modal-content">
            <h2>Xóa sạch giỏ hàng</h2>
            <p>Bạn có muốn xóa tất cả sách đã chọn ?</p>

            <div class="d-flex justify-content-between">
                <a role="button" href="../Apps/Controller/change_order.php?del=1"
                        class="btn btn-outline-danger">Xóa</a>
                <button type="button"
                        onclick="document.getElementById('confirmClean').style.display='none'"
                        class="btn btn-outline-secondary">Hủy</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-center">
    <!-- Grid container -->
    <div class="container p-3 pb-0">
        <!-- Section: Social media -->
        <section class="mb-1 d-flex justify-content-center">
            <!-- Facebook -->
            <a target="_blank" class="rounded-circle m-2 text-white"
               href="https://www.facebook.com/joseph.ttrungchinh" role="button">
                <ion-icon name="logo-facebook"></ion-icon>
            </a>
            <!-- Instagram -->
            <a target="_blank" class="rounded-circle m-2 text-white"
               href="https://www.instagram.com/joseph.trungchinh" role="button">
                <ion-icon name="logo-instagram"></ion-icon>
            </a>
            <!-- Github -->
            <a target="_blank" class="rounded-circle m-2 text-white"
               href="https://github.com/JTC-IT" role="button"> <ion-icon
                    name="logo-github"></ion-icon>
            </a>
        </section>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-white" style="background-color: rgba(0, 0, 0, 0.2);">© 2021 Copyright: Trần Trung Chính</div>
</footer>
<script src="../Media/JS/cart.js"></script>
</body>
</html>