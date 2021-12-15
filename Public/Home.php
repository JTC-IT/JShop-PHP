<?php
    require_once '../Apps/Libs/Category.php';
    require_once '../Apps/Libs/Product.php';
    require_once '../Apps/Libs/Media.php';
    require_once '../Apps/Libs/Cart.php';

    //start session
    session_start();

    //get category
    $category = new Category();
    $listCategory = $category->getCategory();

    //get products
    $product = new Product();
    $param = ["start"=>0, "limit"=>9];

    if(isset($_GET["categoryId"]))
        $param["categoryId"] = (int)$_GET["categoryId"];
    $listProducts = $product->getProducts($param);
    //create class media
    $media = new Media();

    function getImage($id, $index){
        global $media;
        $m = $media->getImage($id,$index);
        if(is_array($m))
            return "../Media/Images/".$m[0]['Url'];
        return "";
    }

    function getlistChildcategory($parent)
    {
        global $category;
        $listChild = $category->getCategoryChild($parent['Id']);
        if($listChild && count($listChild) > 0) {
            echo "<li class='dropdown-submenu category-item dropdown-item'>".
                $parent['Name'].
                "<ul class='submenu dropdown-menu'>";
            foreach ($listChild as $child)
                getlistChildcategory($child);
            echo "</ul></li>";
        }else
            echo "<li onclick='searchByCategory(".$parent['Id'].")' class='category-item dropdown-item'>".$parent['Name']."</li>";
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

    <!--Style-->
    <link rel="stylesheet" href="../Media/CSS/home_style.css">
</head>
<body>
<!-- Header -->
<div class="header-top">
    <!--Left elements-->

    <!--Right elements-->
    <ul class="navbar-nav d-flex flex-row-reverse">
        <!-- Right elements -->
        <?php if(!isset($_SESSION['user'])){ ?>
            <li class="nav-item mr-4 font-weight-bold"><a href="../Apps/Controller/register_control.php" class="nav-link">Đăng ký</a></li>
            <li class="nav-item mr-4 font-weight-bold"><a href="../Apps/Controller/login_control.php" class="nav-link">Đăng nhập</a></li>
        <?php }else{?>
            <li class="nav-item mr-4 font-weight-bold">
                <a href="../Apps/Controller/logout_control.php" class="nav-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    Đăng xuất</a>
            </li>
            <li class="nav-item mr-4 font-weight-bold">
                <a href="Account.php" class="nav-link">
                    <ion-icon name="person"></ion-icon>
                    <?=$_SESSION['user']['Name']?>
                </a>
            </li>
        <?php }?>
    </ul>
</div>
<nav class="navbar navbar-expand-lg sticky-top bg-secondary">
    <div class="container">
        <div class="w-100 d-flex justify-content-between">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="./Home.php">
                <img src="../Media/Images/logo_shop.png" height="55" alt="JShop"/>
            </a>
            <!-- Right elements -->
            <div class="d-flex justify-content-between align-items-center w-50">
                <div class="has-search w-75 h-auto d-flex align-items-center">
                    <ion-icon name="search" class="form-control-feedback" size="small"></ion-icon>
                    <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm" onkeyup="searchByKey(this.value)">
                </div>
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
            <dl>
                <dt class="p-2 bg-warning font-weight-bold text-dark text-center">DANH MỤC</dt>
                    <ul id="list-category">
                        <li onclick='searchByCategory(0,1)' class='category-item dropdown-item'>Tất cả sản phẩm</li>
                        <?php if($listCategory != null) foreach($listCategory as $el){
                            getlistChildcategory($el);
                        } ?>
                    </ul>
            </dl>
            <div></div>
        </div>
        <div class="col-sm-9 gird" style="background-color: #eee;">
            <div class="row pb-3" id="list-products">
                <?php if(isset($listProducts) && count($listProducts) > 0) foreach ($listProducts as $p) { ?>
                    <div class="col-sm-4 pb-3 productItem">
                        <div class="card">
                            <div class="card-body d-flex flex-column align-items-center">
                                <img src='<?=getImage($p['Id'],0)?>' alt='Hình ảnh sản phẩm'>
                                <div class="card-content d-flex flex-column align-items-center mt-3 justify-content-between">
                                    <div class="w-100">
                                        <div class="font-weight-bold text-center text-truncate"><?=$p['Name']?></div>
                                        <small class="text-primary text-center text-truncate">Thương hiệu: <?=$p['Brand']?></small>
                                    </div>
                                    <div class="w-100 mt-3 d-flex align-items-end justify-content-between">
                                        <strong class="text-danger"><?=number_format($p['Price']).' đ'?></strong>
                                        <a class="btn btn-outline-success"
                                           href="./product_details.php?id=<?=$p['Id']?>" role="button">Xem</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else{
                    echo "<div class='alert alert-secondary col-sm-12 text-center' role='alert'>
                          Không tìm thấy sản phẩm nào!
                        </div>";
                } ?>
            </div>
            <div class="col-sm-12 pb-4 text-center">
                <button id="see_more" class="btn btn-outline-primary">Xem thêm >></button>
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