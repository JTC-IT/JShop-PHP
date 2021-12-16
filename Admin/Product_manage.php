<?php
    require_once '../Apps/Libs/Category.php';
    require_once '../Apps/Libs/Product.php';

    //start session
    session_start();

    if(!isset($_SESSION['user']) || $_SESSION['user']['Type'] < 1){
        header("Location: ../Public/Home.php");
        exit();
    }

    //get current_page
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 7;

    //get category
    $category = new Category();
    $listCategory = $category->getCategoryLast();

    //get products
    $product = new Product();
    $categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : 0;
    $key = isset($_GET['key']) ? $_GET['key'] : '';
    $param = ["categoryId"=> $categoryId, "key"=>$key, "start"=>($current_page-1)*$limit, "limit"=>$limit];
    $listProducts = $product->getProducts($param);

    $total_records = $product->total_records($param);

    // tổng số trang
    $total_page = ceil($total_records / $limit);
?>
<!DOCTYPE html>
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

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- IonIcon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS -->
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
<div class="container-fluid">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-7"><h2>QUẢN LÝ <b>SẢN PHẨM</b></h2></div>
                    <div class="col-sm-5 d-flex justify-content-between align-items-center">
                        <a href="Add_Product.php" class="badge badge-pill badge-success p-3">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                             Thêm Sản Phẩm
                        </a>
                        <select class="form-control form-control-sm w-50 ml-3 mr-3"
                                onchange="location = 'Product_manage.php?categoryId='+ this.value">
                            <option value="0" <?=$categoryId==0?"selected":''?>>Tất cả sản phẩm</option>
                            <?php if($listCategory != null) foreach($listCategory as $el){?>
                                <option value="<?=$el['Id']?>" <?=$categoryId==$el['Id']?"selected":''?>>
                                    <?=$el['Name']?>
                                </option>
                            <?php } ?>
                        </select>
                        <form action="Product_manage.php" method="get" class="search-box">
                            <i class="material-icons">&#xE8B6;</i>
                            <input type="text" name="key" class="form-control" placeholder="Tìm sản phẩm" value="<?=$key?>">
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sản phẩm</th>
                    <th>Thương hiệu</th>
                    <th>Tồn kho</th>
                    <th>Giá</th>
                    <th>Ngày cập nhật</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody id="list-products">
                <?php
                $i = 1;
                if (isset($listProducts)) foreach ($listProducts as $p){?>
                    <tr class="product-item">
                        <td><?=$i++?></td>
                        <td><?=$p['Name']?></td>
                        <td><?=$p['Brand']?></td>
                        <td><?=$p['Stocks']?></td>
                        <td><?=number_format($p['Price'])?></td>
                        <td><?=$p['Date_Updated']?></td>
                        <td>
                            <a href="./Update_Product.php?id=<?=$p['Id']?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                            <a href="#myModal" data-id="<?=$p['Id']?>" class="delete" data-toggle="modal" title="Delete"><i class="material-icons">&#xE872;</i></a>
                        </td>
                    </tr>
                <?php  }
                ?>
                </tbody>
            </table>
            <div class="clearfix">
                <div id="result-showing" class="hint-text">Hiển thị <b><?=count($listProducts)?></b> trên <b><?=$total_records?></b> sản phẩm</div>
                <ul class="pagination">
                    <li class="page-item <?=$current_page > 1 ? '': 'disabled'?>">
                        <a href="Product_manage.php?page=<?=$current_page-1?>&categoryId=<?=$categoryId?>&key=<?=$key?>"
                           class="page-link">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link"><?=$current_page?></a></li>
                    <li class="page-item <?=$total_page > $current_page ? '': 'disabled'?>">
                        <a href="Product_manage.php?page=<?=$current_page+1?>&categoryId=<?=$categoryId?>&key=<?=$key?>"
                           class="page-link">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
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
                <a id="btnDeleteProduct" href="#" type="button" class="btn btn-danger d-flex align-items-center justify-content-center text-light">Delete</a>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer>
    <div class="container contact">
        <!-- Section: Social media -->
        <section>
            <!-- Facebook -->
            <a target="_blank" href="https://www.facebook.com/joseph.ttrungchinh" role="button">
                <i class="fa fa-facebook fa-lg" aria-hidden="true"></i>
            </a>
            <!-- Instagram -->
            <a target="_blank" href="https://www.instagram.com/joseph.trungchinh" role="button">
                <i class="fa fa-instagram fa-lg" aria-hidden="true"></i>
            </a>
            <!-- Github -->
            <a target="_blank" href="https://github.com/JTC-IT" role="button">
                <i class="fa fa-github fa-lg" aria-hidden="true"></i>
            </a>
        </section>
    </div>
    <!-- Copyright -->
    <div class="copyright text-center">© 2021 Copyright: Trần Trung Chính</div>
</footer>
<script src="../Media/JS/product_manage_script.js"></script>
</body>
</html>
<?php
    if(isset($_GET['mess'])){
        switch ($_GET['mess']){
            case '-1':
                echo "<script>alert('Thêm sản phẩm không thành công!')</script>";
                break;
            case '1':
                echo "<script>alert('Thêm sản phẩm thành công!')</script>";
                break;
            case '-2':
                echo "<script>alert('Cập nhật sản phẩm không thành công!')</script>";
                break;
            case '2':
                echo "<script>alert('Cập nhật sản phẩm thành công!')</script>";
                break;
        }
    }