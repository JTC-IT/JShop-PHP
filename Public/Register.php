<?php
require_once '../Apps/Libs/Category.php';
require_once '../Apps/Libs/Cart.php';

//start session
session_start();

//get category
$category = new Category();
$listCategory = $category->getCategory();

function getlistChildcategory($parent)
{
    global $category;
    $listChild = $category->getCategoryChild($parent['Id']);
    if($listChild && count($listChild) > 0) {
        echo "<li class='dropdown-submenu'>".
            "<a  class='category-item dropdown-item' tabindex='-1'>".$parent['Name']."</a>".
            "<ul class='submenu dropdown-menu'>";
        foreach ($listChild as $child)
            getlistChildcategory($child);
        echo "</ul></li>";
    }else
        echo "<li><a class='category-item dropdown-item' href='Home.php?categoryId=".$parent['Id']."'>".$parent['Name']."</a></li>";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- IonIcon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../Media/CSS/home_style.css">
</head>
<body>
<!-- Header -->
<div class="header-top">
    <!--Left elements-->

    <!--Right elements-->
    <ul class="navbar-nav d-flex flex-row-reverse">
        <!-- Right elements -->
        <li class="nav-item mr-4 font-weight-bold"><a href="../Apps/Controller/register_control.php" class="nav-link">Đăng ký</a></li>
        <li class="nav-item mr-4 font-weight-bold"><a href="../Apps/Controller/login_control.php" class="nav-link">Đăng nhập</a></li>
    </ul>
</div>
<nav class="navbar navbar-expand-lg sticky-top bg-secondary">
    <!-- Container wrapper -->
    <div class="container">

        <div class="w-100 d-flex justify-content-between">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="./Home.php"> <img
                    src="../Media/Images/logo_shop.png" height="55" alt="JShop" />
            </a>
            <!-- Right elements -->
            <div class="d-flex justify-content-between align-items-center w-50">
                <form action="" class="has-search w-75 h-auto d-flex align-items-center">
                    <ion-icon name="search" class="form-control-feedback" size="small"></ion-icon>
                    <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm" oninput="searchByKey(this)">
                </form>
                <a class="nav-link d-flex align-items-center link-cart" href="CartView.php">
                    <span id="badge-cart" class="badge rounded-pill bg-danger text-light"><?php if(isset($_SESSION['cart'])) echo getTotalQuantity($_SESSION['cart'])?></span>
                    <ion-icon name="cart-outline"></ion-icon>
                </a>
            </div>
        </div>
    </div>
</nav>
<!--Body-->
<div class="container min-vh-100 grid">
    <div class="row">
        <div class="col-sm-3 list-category">
            <ul id="list-category">
                <li class="p-2 bg-warning font-weight-bold text-dark text-center">DANH MỤC</li>
                <li><a class='category-item dropdown-item' href='Home.php?categoryId=0'>Tất cả sản phẩm</a></li>
                <?php if($listCategory != null) foreach($listCategory as $el){
                    getlistChildcategory($el);
                } ?>
            </ul>
            <div></div>
        </div>
        <div class="col-sm-9" style="background: linear-gradient(90deg, hsla(152, 100%, 50%, 1) 0%, hsla(186, 100%, 69%, 1) 100%)">
            <div class="container">
                <div class="p-4 d-flex justify-content-center">
                    <div class="card w-75 p-4">
                        <h3 class="font-weight-bold m-4 text-primary text-center">ĐĂNG KÝ</h3>
                        <form action="../Apps/Controller/register_control.php" method="post">
                            <div class="form-row pl-4 pr-4">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Họ tên:<sup class="text-danger">*</sup></label>
                                    <input type="text" name="name"
                                           class="form-control<?= isset($_SESSION['mess_name'])? ' is-invalid':''?>"
                                           id="name" placeholder="Họ tên"
                                           required>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['mess_name'])? $_SESSION['mess_name']:''?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Số điện thoại:<sup class="text-danger">*</sup></label>
                                    <input type="tel" name="phone"
                                           class="form-control<?= isset($_SESSION['mess_phone'])? ' is-invalid':''?>"
                                           id="phone" placeholder="Số điện thoại"
                                           required>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['mess_phone'])? $_SESSION['mess_phone']:''?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row pl-4 pr-4">
                                <div class="col-md-12 mb-3">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" name="address"
                                           class="form-control"
                                           id="address" placeholder="Địa chỉ">
                                </div>
                            </div>
                            <div class="form-row pl-4 pr-4">
                                <div class="col-md-6 mb-3">
                                    <label for="pass">Mật khẩu:<sup class="text-danger">*</sup></label>
                                    <input type="password" name="pass"
                                           class="form-control<?= isset($_SESSION['mess_pass'])? ' is-invalid':''?>"
                                           id="pass" placeholder="Mật khẩu"
                                           required>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['mess_pass'])? $_SESSION['mess_pass']:''?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="re-pass">Nhập lại mật khẩu:<sup class="text-danger">*</sup></label>
                                    <input type="password" name="re-pass"
                                           class="form-control<?= isset($_SESSION['mess_repass'])? ' is-invalid':''?>"
                                           id="re-pass" placeholder="Mật khẩu"
                                           required>
                                    <div class="invalid-feedback">
                                        <?= isset($_SESSION['mess_repass'])? $_SESSION['mess_repass']:''?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row m-4">
                                <div class="col-md-12 mb-3 text-center">
                                    <button name="register" class="btn btn-success" type="submit">Đăng ký</button>
                                </div>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-md-12 mb-3 text-center">
                                    <small>Bạn đã có tài khoản? <a href="../Apps/Controller/login_control.php">Đăng nhập</a> </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
<script src="../Media/JS/product_details_script.js"></script>
</body>
</html>
<?php
if(isset($_GET['mes']) && $_GET['mes'] == 0)
    echo "<script>alert('Đăng ký không thành công!')</script>";