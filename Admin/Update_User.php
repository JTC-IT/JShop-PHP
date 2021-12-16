<?php
include '../Apps/Libs/User.php';

//start session
session_start();

if(!isset($_GET['id'])){
    header("Location: User_manage.php");
    exit();
}

//get user
$users = new User();

$id = $_GET['id'];
$user = $users->getUser($id);

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
    <link rel="stylesheet" href="../Media/CSS/product_manage_style.css">
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
                <a class="menu_item d-flex flex-column align-items-center" href="Product_manage.php">
                    <span><ion-icon name="dice-outline"></ion-icon></span>QUẢN LÝ SẢN PHẨM
                </a>
                <a class="menu_item d-flex flex-column align-items-center" href="Category_manage.php">
                    <span><ion-icon name="trail-sign-outline"></ion-icon></span>QUẢN LÝ DANH MỤC
                </a>
                <a class="menu_item active d-flex flex-column align-items-center" href="User_manage.php">
                    <span><ion-icon name="people"></ion-icon></span>QUẢN LÝ NGƯỜI DÙNG
                </a>
            </div>
        </div>
    </div>
</div>

<!--Body-->
<div class="container min-vh-100">
    <fieldset class="container w-100 h-100 d-flex justify-content-center">
        <form action="../Apps/Controller/update_user_control.php" method="post" class="w-50 rounded mt-4 p-4"
              style="background-color: #C1C1C1; min-height: 65vh;">
            <!-- Form Name -->
            <h4 class="font-weight-bold text-center border-bottom border-dark">CẬP NHẬT TÀI KHOẢN</h4>
            <input type="hidden" name="id" value="<?=$id?>">
            <div class="form-row mt-4 pl-4 pr-4">
                <div class="col-md-6 mb-3">
                    <label for="name">HỌ TÊN:<sup class="text-danger">*</sup></label>
                    <input type="text" name="name"
                           class="form-control<?= isset($_SESSION['mess_name'])? ' is-invalid':''?>"
                           id="name" placeholder="Họ tên"
                           value="<?=$user['Name']?>"
                           required>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['mess_name'])? $_SESSION['mess_name']:''?>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone">SỐ ĐIỆN THOẠI:<sup class="text-danger">*</sup></label>
                    <input type="tel" name="phone"
                           class="form-control<?= isset($_SESSION['mess_phone'])? ' is-invalid':''?>"
                           id="phone" placeholder="Số điện thoại"
                           value="<?=$user['Phone']?>"
                           required>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['mess_phone'])? $_SESSION['mess_phone']:''?>
                    </div>
                </div>
            </div>
            <div class="form-row pl-4 pr-4">
                <div class="col-md-12 mb-3">
                    <label for="address">ĐỊA CHỈ:</label>
                    <input type="text" name="address"
                           class="form-control"
                           value="<?=$user['Address']?>"
                           id="address" placeholder="Địa chỉ">
                </div>
            </div>
            <div class="form-row pl-4 pr-4">
                <div class="col-md-6 mb-3">
                    <label for="pass">MẬT KHẨU:<sup class="text-danger">*</sup></label>
                    <input type="password" name="pass"
                           class="form-control<?= isset($_SESSION['mess_pass'])? ' is-invalid':''?>"
                           id="pass" placeholder="Mật khẩu"
                           value="<?=$user['Password']?>"
                           required>
                    <div class="invalid-feedback">
                        <?= isset($_SESSION['mess_pass'])? $_SESSION['mess_pass']:''?>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label>LOẠI TÀI KHOẢN:</label>
                    <select class="form-control" name="type">
                        <option value="1" <?=$user['Type'] == 1?"selected":''?>>Nhân viên</option>
                        <option value="2" <?=$user['Type'] == 2?"selected":''?>>Quản lý</option>
                        <option value="0" <?=$user['Type'] == 0?"selected":''?>>Khách hàng</option>
                    </select>
                </div>
            </div>
            <div class="form-row pl-4 pr-4 mt-4">
                <div class="col-12 d-flex justify-content-end">
                    <a href="User_manage.php"
                       role="button"
                       class="btn btn-danger mr-3">Hủy</a>
                    <button type="reset" name="reset" class="btn btn-info mr-3">Reset</button>
                    <button type="submit" name="submit" class="btn btn-success" value="ok">Lưu</button>
                </div>
            </div>
        </form>
    </fieldset>
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
</body>
</html>