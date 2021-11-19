<?php
    require_once '../Apps/Libs/Category.php';
    require_once '../Apps/Libs/Product.php';
    require_once '../Apps/Libs/Media.php';

    //get category
    $category = new Category();
    $listCategory = $category->getCategory();

    //get products
    $id = 1;
    if(isset($_GET['id']))
        $id = $_GET['id'];
    $product = new Product();
    $p = $product->getProduct($id);

    //create class media
    $media = new Media();
    $imgs = $media->getImages($id);

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
            echo "</ul>";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- IonIcon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../Media/CSS/product_details_style.css">
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
    <!-- Container wrapper -->
    <div class="container">

        <div class="w-100 d-flex justify-content-between">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="./Home.php"> <img
                        src="../Media/Images/logo_shop.png" height="55" alt="JShop" />
            </a>
            <!-- Right elements -->
            <div class="d-flex justify-content-between align-items-center w-50">
                <div class="has-search w-75 h-auto d-flex align-items-center">
                    <ion-icon name="search" class="form-control-feedback" size="small"></ion-icon>
                    <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm" oninput="searchByKey(this)">
                </div>
                <a class="nav-link d-flex align-items-center link-cart" href="#">
                    <span id="badge-cart" class="badge rounded-pill bg-danger text-light"></span>
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
                <?php if($listCategory != null) foreach($listCategory as $el){
                    getlistChildcategory($el);
                } ?>
            </ul>
            <div></div>
        </div>
        <div class="col-sm-9">
            <h3 class="font-weight-bold mt-4 pl-2 text-secondary">CHI TIẾT SẢN PHẨM</h3>
            <div class="card">
                <div class="container-fluid">
                    <div class="wrapper row">
                        <div class="preview col-md-6">
                            <div class="preview-pic tab-content">
                                <div class="tab-pane active"><img id="pic-show" src="../Media/Images/<?=$imgs[0]['Url']?>"/></div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <?php
                                foreach ($imgs as $img) {
                                    echo "<li><a><img onclick='showImage(this)' src=\"../Media/Images/".$img['Url']."\"/></a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <form class="details col-md-6" action="../Apps/Controller/order_control.php" method="post">
                            <input type="hidden" name="id" value="<?=$p['Id']?>">
                            <input name="img" type="hidden" value="../Media/Images/<?=$imgs[0]['Url']?>">
                            <input type="hidden" name="name" value="<?=$p['Name']?>">
                            <input type="hidden" name="brand" value="<?=$p['Brand']?>">
                            <input type="hidden" name="price" value="<?=$p['Price']?>">
                            <h3 class="product-title"><?=$p['Name']?></h3>
                            <small class="text-primary font-weight-bold">Thương hiệu: <?=$p['Brand']?></small>
                            <p class="product-description text-justify"><?=$p['Description']?></p>
                            <h4 class="price">Giá: <span><?=number_format($p['Price']).' đ'?></span></h4>
                            <div class="count-input">
                                <label for="quantity">Số lượng:</label>
                                <label>
                                    <input class="form-control" type="number" name="quantity" value="1" min="1" max="30">
                                </label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="add-to-cart btn btn-default" type="submit" name="submit">Thêm giỏ hàng</button>
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
