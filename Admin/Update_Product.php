<?php
require_once '../Apps/Libs/Category.php';
require_once '../Apps/Libs/Product.php';
require_once '../Apps/Libs/Media.php';

//start session
session_start();

//get category
$category = new Category();
$listCategory = $category->getCategoryLast();

//get products
$id = 1;
if(isset($_GET['id']))
    $id = $_GET['id'];
$product = new Product();
$p = $product->getProduct($id);

//get images product
$media = new Media();
$images = $media->getImages($id);

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Style-->
    <link rel="stylesheet" href="../Media/CSS/product_manage_style.css">
    <link rel="stylesheet" href="../Media/CSS/add_product_style.css">
</head>
<body>
<!-- Header -->
<div class="header-top">
    <!--Right elements-->
    <ul class="navbar-nav">
        <!-- Right elements -->
        <li class="nav-item"><a href="../Apps/Controller/logout_control.php">Đăng xuất</a></li>
        <li class="nav-item"><?=$_SESSION['user']['Name']?></li>
    </ul>
</div>
<div class="nav-menu">
    <div class="row">
        <!-- Navbar brand -->
        <div class="col-sm-4 d-flex justify-content-center align-items-center">
            <a href="Product_manage.php">
                <img src="../Media/Images/logo_shop.png" height="55" alt="JShop" />
            </a>
        </div>
        <!-- Right elements -->
        <div class="col-sm-8 h-100">
            <div class="d-flex align-items-center">
                <a class="menu_item active d-flex flex-column align-items-center" href="Product_manage.php">
                    <span><ion-icon name="dice"></ion-icon></span>QUẢN LÝ SẢN PHẨM
                </a>
                <a class="menu_item d-flex flex-column align-items-center" href="Category_manage.php">
                    <span><ion-icon name="trail-sign-outline"></ion-icon></span>QUẢN LÝ DANH MỤC
                </a>
                <?php if($_SESSION['user']['Type'] == 2){ ?>
                    <a class="menu_item d-flex flex-column align-items-center" href="User_manage.php">
                        <span><ion-icon name="people-outline"></ion-icon></span>QUẢN LÝ NGƯỜI DÙNG
                    </a>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<!--Body-->
<div class="container min-vh-100">
    <form enctype="multipart/form-data" class="form-horizontal grid mt-3" onreset="clear_images()" action="../Apps/Controller/update_product_control.php" method="post">
        <!-- Form Name -->
        <h4 class="font-weight-bold text-center border-bottom border-dark">CẬP NHẬT SẢN PHẨM</h4>
        <fieldset class="row">
            <!--Left elements-->
            <div class="col-sm-7 mt-4">
                <!-- Text input-->
                <input type="hidden" name="id" value="<?=$p['Id']?>">
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="name">TÊN SẢN PHẨM</label>
                    <div class="col-sm-9">
                        <input name="name" placeholder="Tên sản phẩm" class="form-control input-md" required="" type="text" value="<?=$p['Name']?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="description">MÔ TẢ</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description" rows="8"><?=$p['Description']?></textarea>
                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="category">DANH MỤC</label>
                    <div class="col-sm-9">
                        <select name="category" class="form-control">
                            <?php if($listCategory != null) foreach($listCategory as $el){?>
                                <option value="<?=$el['Id']?>" <?= $p['CategoryId'] == $el['Id'] ? 'selected': '' ?>><?=$el['Name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="brand">THƯƠNG HIỆU</label>
                    <div class="col-sm-9">
                        <input name="brand" placeholder="Thương hiệu" class="form-control input-md" required="" type="text" value="<?=$p['Brand']?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="price">GIÁ</label>
                    <div class="col-sm-9">
                        <input name="price" placeholder="vnđ" class="form-control input-md" required="" type="text" value="<?=$p['Price']?>">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="stock">SỐ LƯỢNG</label>
                    <div class="col-sm-9">
                        <input name="stock" placeholder="Số lượng" class="form-control input-md" required="" type="number" min="1" value="<?=$p['Stocks']?>">
                    </div>
                </div>

                <!-- Search input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="unit">ĐƠN VỊ</label>
                    <div class="col-sm-9">
                        <input name="unit" placeholder="Dơn vị tính" class="form-control input-md" required="" type="text" value="<?=$p['Unit']?>">
                    </div>
                </div>

                <!-- Search input-->
                <div class="form-group row">
                    <label class="col-sm-3 control-label mt-2" for="model-year">ĐỜI SẢN PHẨM</label>
                    <div class="col-sm-9">
                        <input id="model-year" name="model-year" placeholder="Đời sản phẩm" class="form-control input-md" type="number" value="<?=$p['Model_Year']?>" min="1" required="">
                    </div>
                </div>
            </div>

            <!--Right elements-->
            <div class="col-sm-5 mt-4">
                <!-- File Button -->
                <div class="form-group row">
                    <label class="col-sm-12 control-label" >HÌNH ẢNH SẢN PHẨM</label>
                    <div class="col-sm-12 preview-images" title="<?=$image['Id']?>">
                        <?php foreach ($images as $image){ ?>
                            <div class="image-box">
                                <a href="#" title="<?=$image['Id']?>" class="badge badge-pill badge-danger">x</a>
                                <img src='../Media/Images/<?=$image['Url']?>' class='image-preview' alt="Ảnh sản phẩm">
                            </div>
                        <?php } ?>
                    </div>
                    <label class="col-sm-12 control-label mt-4" for="main_image">THÊM HÌNH ẢNH SẢN PHẨM</label>
                    <div class="col-sm-12">
                        <input id="input_images" name="images[]" class="form-control" multiple type="file" accept="image/*" onchange="preview_image(event);">
                    </div>
                    <div class="col-sm-12 preview-images" id="preview-images">
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="row mt-3">
            <!-- Button -->
            <div class="col-sm-12">
                <div class="w-100 d-flex justify-content-end">
                    <a href="Product_manage.php" class="btn btn-secondary d-flex align-items-center justify-content-center">Hủy</a>
                    <a href="#myModal" data-toggle="modal" role="button" class="btn btn-danger d-flex align-items-center justify-content-center">Xóa</a>
                    <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="material-icons">&#xE5CD;</i>
                </div>
                <h4 class="modal-title w-100">Xóa sản phẩm?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sản phẩm? Sản phẩm bị xóa sẽ không thể bán.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="../Apps/Controller/delete_product_control.php?id=<?=$id?>" type="button" class="btn btn-danger d-flex align-items-center justify-content-center text-light">Delete</a>
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
<script src="../Media/JS/product_manage_script.js"></script>
</body>
</html>