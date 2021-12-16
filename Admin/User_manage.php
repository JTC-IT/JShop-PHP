<?php
require_once '../Apps/Libs/User.php';

//start session
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['Type'] < 1){
    header("Location: ../Public/Home.php");
    exit();
}

//get user
$users = new User();

$type = isset($_GET['type']) ? trim($_GET['type']) : 1;

$key = isset($_GET['key']) ? trim($_GET['key']) : '';
$listUsers = $users->getUsers($type,$key);

$types = ['0'=>"Khách hàng", '1'=>"Nhân viên", '2'=>"Quản lý"];
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
    <div class="container-fluid">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>QUẢN LÝ <b>TÀI KHOẢN</b></h2></div>
                        <div class="col-sm-4 d-flex justify-content-between align-items-center">
                            <a href="Add_User.php" class="badge badge-pill badge-success p-2" title="Thêm tài khoản">
                                <i class="fa fa-user-plus" aria-hidden="true" style="font-size: 20px"></i>
                            </a>
                            <select class="form-control form-control-sm w-25 ml-3 mr-3"
                                    onchange="location = 'User_manage.php?type='+ this.value">
                                <option value="0" <?=$type==0?"selected":""?>>Khách hàng</option>
                                <option value="1" <?=$type==1?"selected":""?>>Nhân viên</option>
                                <option value="2" <?=$type==2?"selected":""?>>Quản lý</option>
                                <option value="-1" <?=$type==-1?"selected":""?>>Đã khóa</option>
                            </select>
                            <form action="User_manage.php" method="get" class="search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="hidden" name="type" value="<?=$type?>">
                                <input type="text" name="key" class="form-control" placeholder="Tìm tài khoản" value="<?=$key?>">
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Số ĐT</th>
                        <th>Địa chỉ</th>
                        <th>Ngày tạo</th>
                        <th>Loại T.khoản</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody id="list-products">
                    <?php
                    $i = 1;
                    if (count($listUsers) > 0) foreach ($listUsers as $p){?>
                        <tr class="product-item">
                            <td><?=$i++?></td>
                            <td><?=$p['Name']?></td>
                            <td><?=$p['Phone']?></td>
                            <td><?=$p['Address']?></td>
                            <td><?=$p['Date_Created']?></td>
                            <td><?=$types[$p['Type']]?></td>
                            <td><?=$p['Is_Blocked'] == 0? "Hoạt động":"Đã khóa"?></td>
                            <td>
                                <a href="./Update_User.php?id=<?=$p['Id']?>" class="edit" title="Sửa" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <?php if($p['Is_Blocked'] == 0){ ?>
                                    <a data-toggle="modal" data-target="#lockModal" data-whatever="<?=$p['Id']?>"
                                       class="text-danger" title="Khóa">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </a>
                                <?php } else { ?>
                                    <a data-toggle="modal" data-target="#unlockModal" data-whatever="<?=$p['Id']?>"
                                       class="text-danger" title="Mở Khóa">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php } else {
                        echo "<tr><td colspan='8' class='alert alert-info text-center' role='alert'>Không tìm thấy kết quả nào!</td></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal lock-->
    <div class="modal fade" id="lockModal" tabindex="-1" role="dialog" aria-labelledby="lockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="../Apps/Controller/block_user_control.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="lockModalLabel">Khóa Tài Khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="id" name="id" type="hidden">
                    <input name="blocked" type="hidden" value="1">
                    <p id="modal-content">Bạn có chắc chắn muốn Khóa Tài khoản này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="submit">Khóa</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal unlock-->
    <div class="modal fade" id="unlockModal" tabindex="-1" role="dialog" aria-labelledby="unlockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="../Apps/Controller/block_user_control.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="unlockModalLabel">Mở Khóa Tài Khoản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="id" name="id" type="hidden">
                    <input name="blocked" type="hidden" value="0">
                    <p id="modal-content">Bạn có muốn Mở khóa Tài khoản này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success" name="submit">Mở khóa</button>
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
            $('#lockModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) ;
                var recipient = button.data('whatever');
                var modal = $(this);
                modal.find('.modal-body #id').val(recipient);
            });
            $('#unlockModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) ;
                var recipient = button.data('whatever');
                var modal = $(this);
                modal.find('.modal-body #id').val(recipient);
            });
        });
    </script>
    </html>
<?php
if(isset($_GET['mess'])){
    switch ($_GET['mess']){
        case '-1':
            echo "<script>alert('Thêm tài khoản không thành công!')</script>";
            break;
        case '1':
            echo "<script>alert('Thêm tài khoản thành công!')</script>";
            break;
        case '-2':
            echo "<script>alert('Cập nhật tài khoản không thành công!')</script>";
            break;
        case '2':
            echo "<script>alert('Cập nhật tài khoản thành công!')</script>";
            break;
    }
}