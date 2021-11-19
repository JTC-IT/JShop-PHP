<?php
//start session
session_start();

$cart = [];

if(isset($_SESSION['cart']))
    $cart = $_SESSION['cart'];

$check = count($cart) > 0;

function getThanhTien()
{
    global $cart;
    $sum = 0;
    foreach ($cart as $item) {
        $sum += (int) $item['price']*$item['quantity'];
    }
    return number_format($sum).' đ';
}

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                <a class="nav-link d-flex align-items-center link-cart" href="#">
                    <span id="badge-cart" class="badge rounded-pill bg-danger text-light"><?php if($check) echo count($cart)?></span>
                    <ion-icon name="cart-outline"></ion-icon>
                </a>
            </div>
        </div>
    </div>
</nav>
<!--Body-->
<div class="container min-vh-100 grid">
    <div class="row">
        <!-- Alert-->
        <div class="alert alert-info text-center" style="margin-bottom: 30px;"
             role="alert">
			<span id="alert-status">
				<?php if(!$check)
					echo "Giỏ hàng trống !";
				else
					echo "Giỏ hàng có ".count($cart)." sản phẩm chưa được thanh toán !";
				?>
			</span>
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
                    for ($i = 0; $i < count($cart); $i++){
                        $item = $cart[$i];
                        ?>
                        <tr class="cart-item">
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="<?=$item['img']?>">
                                        <img src="<?=$item['img']?>" alt="Book">
                                    </a>
                                    <div class="product-info">
                                        <h6 class="product-title font-weight-bold text-truncate">
                                            <a href="#"><?=$item['name']?></a>
                                        </h6>
                                        <span class="text-primary text-truncate"><?=$item['brand']?></span>
                                        <span><em>Giá: </em><?=number_format($item['img'])." đ"?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="count-input">
                                    <select class="form-control selectAmount"
                                            onchange="changeAmount(this,<?=$item['id']?>)">
                                        <?php
                                        for ($i = 1; $i < 10 || $i < (int)$item['quantity']; $i++){
                                            echo "<option value='$i' ";
                                            if($i == (int)$item['quantity'])
                                                echo "selected";
                                            echo ">$i</option>";
                                        } ?>
                                    </select>
                                </div>
                            </td>
                            <td id="intoMoney" class="text-center text-lg text-medium"><?=number_format((int)$item['price']*(int)$item['quantity'])." đ"?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-ligh remove-from-cart"
                                        onclick="removeCartItem(this,<?=$item['id']?>)">
                                    <ion-icon name="trash"></ion-icon>
                                </button>
                            </td>
                        </tr>
                    <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer">
            <div class="column text-lg">
                Thành tiền:
                <h3 id="sumPay" class="d-inline font-weight-bold">
                    <?php if($check) echo getThanhTien();
                        else echo "0 đ";
                    ?>
                </h3>
            </div>
        </div>
        <div class="shopping-cart-footer">
            <div class="column">
                <a class="btn btn-outline-primary" href="Home.php">
                    <i class="icon-arrow-left"></i>Tiếp tục mua</a>
            </div>
            <div class="column">
                <?php if($check){?>
                    <button type="button"
                            id="btn-payCart"
                            class="btn btn-success"
                            onclick="showConfirmOrder()">
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
            <p>Đặt tất cả các sách trong giỏ hàng của bạn.</p>

            <div class="d-flex justify-content-between">
                <button type="button"
                        onclick="document.getElementById('modalConfirmOrder').style.display='none'"
                        class="btn btn-outline-secondary">Hủy bỏ</button>
                <a href="#" role="button" class="btn btn-success text-light">Đặt
                    hàng</a>
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
                <button type="button" onclick="clearCart()"
                        class="btn btn-outline-danger">Xóa</button>
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
<script src="../Media/JS/home_script.js"></script>
</body>
</html>