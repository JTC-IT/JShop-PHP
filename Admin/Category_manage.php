<?php
require_once '../Apps/Libs/Category.php';
require_once '../Apps/Libs/Product.php';

//start session
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['Type'] < 1){
    header("Location: ../Public/Home.php");
    exit();
}

//get category
$category = new Category();

$key = isset($_GET['key']) ? trim($_GET['key']) : '';
$listCategory = $category->getAllCategory($key);

$product = new Product();
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
                    <a class="menu_item d-flex flex-column align-items-center" href="Product_manage.php">
                        <span><ion-icon name="dice-outline"></ion-icon></span>QUẢN LÝ SẢN PHẨM
                    </a>
                    <a class="menu_item active d-flex flex-column align-items-center" href="Category_manage.php">
                        <span><ion-icon name="trail-sign"></ion-icon></span>QUẢN LÝ DANH MỤC
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
                        <div class="col-sm-7"><h2>QUẢN LÝ <b>DANH MỤC</b></h2></div>
                        <div class="col-sm-5 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-success badge-pill p-2"
                                    data-toggle="modal"
                                    data-target="#addModal"
                                    style="font-size: 14px">
                                <i class="fa fa-plus-circle mr-2" aria-hidden="true"></i>
                                Thêm Danh Mục
                            </button>
                            <form action="Category_manage.php" method="get" class="search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" name="key" class="form-control" size="35" placeholder="Tìm danh mục" value="<?=$key?>">
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Danh mục</th>
                        <th>Danh mục cha</th>
                        <th>Sản phẩm</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody id="list-products">
                    <?php
                    $i = 1;
                    if (count($listCategory)>0) foreach ($listCategory as $p){?>
                        <tr class="product-item">
                            <td><?=$i++?></td>
                            <td><?=$p['Name']?></td>
                            <td><?=is_null($p['ParentId'])?'':$category->getName([':id'=>$p['ParentId']])[0]['Name']?></td>
                            <td><?=$product->total_records(['categoryId'=>$p['Id']]) ?></td>
                            <td><?=$p['Date_Updated']?></td>
                            <td>
                                <button type="button" class="edit text-warning border-0"
                                        data-toggle="modal" data-target="#editModal"
                                        data-id="<?=$p['Id']?>"
                                        data-name="<?=$p['Name']?>"
                                        data-parent="<?=isset($p['ParentId'])?$p['ParentId']:'NULL'?>">
                                    <i class="material-icons">&#xE254;</i>
                                </button>
                                <a href="#myModal" data-id="<?=$p['Id']?>" class="delete" data-toggle="modal" title="Delete"><i class="material-icons">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php } else {
                        echo "<tr><td colspan='6' class='alert alert-info text-center' role='alert'>Không tìm thấy kết quả nào!</td></tr>";
                    }?>
                    </tbody>
                </table>
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
                    <h4 class="modal-title w-100">Xóa Danh mục?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa danh mục?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a id="btnDeleteCategory" role="button" href="" type="button" class="btn btn-danger text-light pt-2">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="../Apps/Controller/add_category_control.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">THÊM DANH MỤC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">DANH MỤC:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="col-form-label">DANH MỤC CHA:</label>
                            <select class="form-control" id="parent" name="parent">
                                <option value="NULL" selected>Không có</option>
                                <?php foreach($category->getAllCategory() as $el){?>
                                    <option value="<?=$el['Id']?>">
                                        <?=$el['Name']?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="submit" name="submit" class="btn btn-success">Thêm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="../Apps/Controller/update_category_control.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">CẬP NHẬT DANH MỤC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="id" name="category-id">
                        <div class="form-group">
                            <label for="name" class="col-form-label">DANH MỤC:</label>
                            <input type="text" class="form-control" id="name" name="category-name" required>
                        </div>
                        <div class="form-group">
                            <label for="parent" class="col-form-label">DANH MỤC CHA:</label>
                            <select class="form-control" id="parent" name="category-parent">
                                <option value="NULL">Không có</option>
                                <?php foreach($category->getAllCategory() as $el){?>
                                    <option value="<?=$el['Id']?>">
                                        <?=$el['Name']?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="submit" name="submit" class="btn btn-success">Lưu</button>
                </div>
            </form>
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
    </body>
    <script>
        $(document).ready(function() {
            $('a[data-toggle=modal]').click(function () {
                if (typeof $(this).data('id') !== 'undefined') {
                    $("#btnDeleteCategory").attr("href","../Apps/Controller/delete_category_control.php?id="+$(this).data('id'));
                }
            });

            $('#editModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const id = button.data('id');
                const name = button.data('name');
                const parent = button.data('parent');
                const modal = $(this);
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #parent').val(parent);
            });
        });
    </script>
    </html>
<?php
if(isset($_GET['mess'])){
    switch ($_GET['mess']){
        case '-1':
            echo "<script>alert('Thêm danh mục không thành công!')</script>";
            break;
        case '1':
            echo "<script>alert('Thêm danh mục thành công!')</script>";
            break;
        case '-2':
            echo "<script>alert('Cập nhật danh mục không thành công!')</script>";
            break;
        case '2':
            echo "<script>alert('Cập nhật danh mục thành công!')</script>";
            break;
    }
}