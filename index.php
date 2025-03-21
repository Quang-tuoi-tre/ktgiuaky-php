<?php
// Khởi tạo session để quản lý trạng thái đăng nhập
session_start();

// Require các controller cần thiết
require_once('app/controllers/SinhVienController.php');
require_once('app/controllers/NganhHocController.php');
require_once('app/controllers/DangKyController.php');
require_once('app/controllers/CartController.php');
require_once('app/controllers/HocPhanController.php');

// Khởi tạo controller
$sinhVienController = new SinhVienController();
$dangKyController = new DangKyController();
$cartController = new CartController();
$hocphancontroller = new HocPhanController();

// Xử lý URL
$url = isset($_GET['url']) ? $_GET['url'] : '/';

switch ($url) {
    // Các route cho SinhVien
    case '/':
    case 'SinhVien':
        $sinhVienController->index();
        break;

    case 'SinhVien/login':
        $sinhVienController->login();
        break;
    case 'SinhVien/add':
        $sinhVienController->add();
        break;
    case 'SinhVien/save':
        $sinhVienController->save();
        break;
    case (preg_match('/SinhVien\/edit\/(\d+)/', $url, $matches) ? true : false):
        $sinhVienController->edit($matches[1]);
        break;
    case 'SinhVien/update':
        $sinhVienController->update();
        break;
    case (preg_match('/SinhVien\/delete\/(\d+)/', $url, $matches) ? true : false):
        $sinhVienController->delete($matches[1]);
        break;
    case (preg_match('/SinhVien\/confirm_delete\/(\d+)/', $url, $matches) ? true : false):
        $sinhVienController->confirm_delete($matches[1]);
        break;
    case (preg_match('/SinhVien\/infor\/(\d+)/', $url, $matches) ? true : false):
        $sinhVienController->infor($matches[1]);
        break;

    // Các route cho HocPhan (CartController và DangKyController đã tách ra)
    case 'HocPhan':
        $hocphancontroller->index();  // Hiển thị danh sách học phần
        break;
    case 'DangKy/addToCart':
        $dangKyController->addToCart();
        break;
    case 'Cart/cart':
        $cartController->showCart();
        break;
    case 'DangKy/registerCart':
        $dangKyController->registerCart();
        break;
   
    case (preg_match('/Cart\/removeFromCart\/(\w+)/', $url, $matches) ? true : false):
        $cartController->removeFromCart($matches[1]);
        break;
    // Xóa tất cả học phần trong giỏ hàng
    case 'Cart/clearCart':
        $cartController->clearCart();
        break;

    // Các route cho NganhHoc
   
    case 'DangKy/dangky':
        include 'app/views/dangky/dangky.php';
        break;
    case 'DangKy/confirmRegister':
        include 'app/views/dangky/confirmRegister.php';
        break;    

    default:
        echo "Trang không tồn tại";
        break;
}
?>
