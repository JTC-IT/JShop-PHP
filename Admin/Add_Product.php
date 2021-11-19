<?php
include '../Apps/Libs/Category.php';

//get category
$category = new Category();
$listCategory = $category->getAllCategory();

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
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- IonIcon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <!--Style-->
    <link rel="stylesheet" href="../Media/CSS/add_product_style.css">
</head>
<body>
<!-- Header -->
<div class="header-top">
    <!--Right elements-->
    <ul class="navbar-nav">
        <!-- Right elements -->
        <li class="nav-item"><a href="#">LOGOUT</a></li>
        <li class="nav-item"><a href="#">ADMIN</a></li>
    </ul>
</div>
<nav class="navbar">
    <!-- Container wrapper -->
    <div class="container">
        <div class="w-100 d-flex justify-content-between">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-2 mt-lg-0" href="../Public/Home.php">
                <img src="../Media/Images/logo_shop.png" height="55" alt="JShop" />
            </a>
            <!-- Right elements -->
            <div class="d-flex justify-content-between align-items-center w-50">
            </div>
        </div>
    </div>
</nav>

<!--Body-->
<div class="container min-vh-100">
<form enctype="multipart/form-data" class="form-horizontal grid mt-3" onreset="clear_images()" action="../Apps/Controller/add_product_control.php" method="post">
    <!-- Form Name -->
    <h4 class="font-weight-bold text-center border-bottom border-dark">THÊM SẢN PHẨM</h4>
    <fieldset class="row">
        <!--Left elements-->
        <div class="col-sm-7 mt-4">
            <!-- Text input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="name">TÊN SẢN PHẨM</label>
                <div class="col-sm-9">
                    <input id="name" name="name" placeholder="Tên sản phẩm" class="form-control input-md" required="" type="text">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="description">MÔ TẢ</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description" rows="8"></textarea>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="category">DANH MỤC</label>
                <div class="col-sm-9">
                    <select id="category" name="category" class="form-control">
                        <?php if($listCategory != null) foreach($listCategory as $el){?>
                            <option value="<?=$el['Id']?>"><?=$el['Name']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="brand">THƯƠNG HIỆU</label>
                <div class="col-sm-9">
                    <input id="brand" name="brand" placeholder="Thương hiệu" class="form-control input-md" required="" type="text">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="price">GIÁ</label>
                <div class="col-sm-9">
                    <input id="price" name="price" placeholder="vnđ" class="form-control input-md" required="" type="text">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="stock">SỐ LƯỢNG</label>
                <div class="col-sm-9">
                    <input id="stock" name="stock" placeholder="Số lượng" class="form-control input-md" required="" type="number" min="1" value="1">
                </div>
            </div>

            <!-- Search input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="unit">ĐƠN VỊ</label>
                <div class="col-sm-9">
                    <input id="unit" name="unit" placeholder="Dơn vị tính" class="form-control input-md" required="" type="text">
                </div>
            </div>

            <!-- Search input-->
            <div class="form-group row">
                <label class="col-sm-3 control-label mt-2" for="model-year">ĐỜI SẢN PHẨM</label>
                <div class="col-sm-9">
                    <input id="model-year" name="model-year" placeholder="Đời sản phẩm" class="form-control input-md" type="number" value="1" min="1" required="">
                </div>
            </div>
        </div>

        <!--Right elements-->
        <div class="col-sm-5 mt-4">
            <!-- File Button -->
            <div class="form-group row">
                <label class="col-sm-12 control-label" for="main_image">HÌNH ẢNH SẢN PHẨM</label>
                <div class="col-sm-12">
                    <input id="input_images" name="images[]" class="form-control" multiple type="file" accept="image/*" onchange="preview_image(event);">
                </div>
                <div class="col-sm-12" id="preview-images">
                </div>
            </div>
        </div>
    </fieldset>
    <div class="row mt-3">
        <!-- Button -->
        <div class="col-sm-12">
            <div class="w-100 d-flex justify-content-end">
                <a href="Product_manage.php" class="btn btn-danger d-flex align-items-center justify-content-center">Hủy</a>
                <button type="reset" name="reset" class="btn btn-info">Reset</button>
                <button type="submit" name="submit" class="btn btn-success">Thêm</button>
            </div>
        </div>
    </div>
</form>
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
<script src="../Media/JS/product_manage_script.js"></script>
</body>
</html>