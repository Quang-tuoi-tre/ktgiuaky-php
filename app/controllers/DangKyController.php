<?php
require_once('app/models/HocPhanModel.php');
require_once('app/models/SinhVienModel.php');
require_once('app/config/database.php');
require_once('app/models/DangKyModel.php');
class DangKyController
{
    private $hocPhanModel;
    private $sinhVienModel;
    private $dangKyModel;  // Đã khai báo dangKyModel
    private $db;

    public function __construct()
    {
        // Kết nối cơ sở dữ liệu
        $this->db = (new Database())->getConnection();
        
        // Khởi tạo các models
        $this->hocPhanModel = new HocPhanModel($this->db);
        $this->sinhVienModel = new SinhVienModel($this->db);
        $this->dangKyModel = new DangKyModel($this->db);  // Khởi tạo dangKyModel
    }


    //hàm RegisterCart không hiển thị thông tin đăng ký nhưng lưu được database 
//     public function registerCart()
// {
//     if (!isset($_SESSION['MaSV'])) {
//         header('Location: /qlsinhvien/SinhVien/login');
//         exit();
//     }

//     // Lấy thông tin sinh viên từ session
//     $maSV = $_SESSION['MaSV'];

//     // Thêm học phần vào bảng đăng ký (DangKy)
//     if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
//         $ngayDangKy = date('Y-m-d');
//         $maDK = $this->dangKyModel->addDangKy($maSV, $ngayDangKy);

//         // Thêm chi tiết học phần vào bảng ChiTietDangKy và giảm số lượng học phần
//         foreach ($_SESSION['cart'] as $hocPhan) {
//             $this->dangKyModel->addChiTietDangKy($maDK, $hocPhan->MaHP);
//             $this->hocPhanModel->updateSoLuongDuKien($hocPhan->MaHP); // Giảm số lượng học phần
//         }

//         // Xóa giỏ hàng sau khi đăng ký
//         unset($_SESSION['cart']);
//     }

//     // Chuyển hướng đến trang danh sách học phần
//     header('Location: /qlsinhvien/SinhVien');
//     exit();
// }




    // Xử lý việc lưu thông tin đăng ký học phần
    public function registerCart()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }
    
        // Lấy thông tin sinh viên từ session
        $maSV = $_SESSION['MaSV'];
        $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($maSV);  // Lấy thông tin sinh viên
    
        // Thêm học phần vào bảng đăng ký (DangKy) chỉ khi xác nhận
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            // Chuyển hướng đến trang đăng ký
            include 'app/views/dangky/dangky.php';
            exit();
        } else {
            // Nếu giỏ hàng trống
            header('Location: /qlsinhvien/HocPhan');
            exit();
        }
    }

    
    public function confirmRegister()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }
    
        // Lấy thông tin sinh viên từ session
        $maSV = $_SESSION['MaSV'];
        $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($maSV);
    
        // Gỡ lỗi: Kiểm tra nội dung session
        echo "<pre>Session: ";
        var_dump($_SESSION);
        echo "</pre>";
    
        // Gỡ lỗi: Kiểm tra giá trị của $maSV
        echo "<p>Mã sinh viên: " . htmlspecialchars($maSV) . "</p>";
    
        // Lưu thông tin đăng ký vào bảng DangKy
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $ngayDangKy = date('Y-m-d');
    
            // Gỡ lỗi: Kiểm tra giá trị của $ngayDangKy
            echo "<p>Ngày đăng ký: " . htmlspecialchars($ngayDangKy) . "</p>";
    
            $maDK = $this->dangKyModel->addDangKy($maSV, $ngayDangKy);
    
            // Gỡ lỗi: Kiểm tra giá trị của $maDK
            echo "<p>Mã đăng ký: " . htmlspecialchars($maDK) . "</p>";
    
            // Thêm chi tiết học phần vào bảng ChiTietDangKy và giảm số lượng học phần
            foreach ($_SESSION['cart'] as $hocPhan) {
                $this->dangKyModel->addChiTietDangKy($maDK, $hocPhan->MaHP);
    
                // Gỡ lỗi: Kiểm tra dữ liệu học phần
                echo "<pre>Học phần: ";
                var_dump($hocPhan);
                echo "</pre>";
    
                $this->hocPhanModel->updateSoLuongDuKien($hocPhan->MaHP);
            }
    
            // Xóa giỏ hàng sau khi đăng ký
            unset($_SESSION['cart']);
    
            // Sau khi lưu đăng ký, chuyển hướng đến trang danh sách học phần hoặc trang chủ
            header('Location: /qlsinhvien/SinhVien');
            exit();
        } else {
            // Nếu giỏ hàng trống
            echo "Giỏ hàng không có học phần.";
        }
    }






    // Thêm học phần vào giỏ hàng
    public function addToCart()
    {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }
    
        // Kiểm tra và khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    
        $maHP = $_POST['MaHP'];
        $hocPhan = $this->hocPhanModel->getHocPhanByMaHP($maHP);
    
        $_SESSION['cart'][] = $hocPhan;

        header('Location: /qlsinhvien/Cart/cart');
        exit();
    }

    // Xử lý việc lưu đăng ký
    // Xử lý việc lưu thông tin đăng ký học phần


}
?>
