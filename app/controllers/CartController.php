<?php
require_once('app/models/HocPhanModel.php');
require_once('app/models/SinhVienModel.php');
require_once('app/config/database.php');

class CartController
{
    private $hocPhanModel;
    private $sinhVienModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->hocPhanModel = new HocPhanModel($this->db);
        $this->sinhVienModel = new SinhVienModel($this->db);
    }

    // Hiển thị giỏ hàng
    public function showCart()
    {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }
        $maSV = $_SESSION['MaSV'];
        $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($maSV); 

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/cart/cart.php';
    }

    // Xóa học phần khỏi giỏ hàng
    public function removeFromCart($maHP)
    {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $hocPhan) {
                if ($hocPhan->MaHP === $maHP) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
        }

        header('Location: /qlsinhvien/Cart/cart');
        exit();
    }

    // Xóa tất cả học phần trong giỏ
    public function clearCart()
    {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }

        unset($_SESSION['cart']);
        header('Location: /qlsinhvien/Cart/cart');
        exit();
    }
}
?>
