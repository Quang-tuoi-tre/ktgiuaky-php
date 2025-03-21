<?php
// Require Database và các Model cần thiết
require_once('app/config/database.php');
require_once('app/models/SinhVienModel.php');
require_once('app/models/NganhHocModel.php');

class SinhVienController
{
    private $sinhVienModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->sinhVienModel = new SinhVienModel($this->db);
    }

    // Hiển thị danh sách sinh viên
    public function index()
    {
        $sinhViens = $this->sinhVienModel->getSinhViens();
        include 'app/views/sinhvien/list.php';
    }



    public function login()
    {
        // Nếu có yêu cầu POST (người dùng gửi thông tin đăng nhập)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['MaSV'];
    
            // Kiểm tra mã sinh viên có hợp lệ không
            $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($maSV);
    
            if ($sinhVien) {
                // Nếu mã sinh viên tồn tại, lưu MaSV vào session
                $_SESSION['MaSV'] = $sinhVien->MaSV;
    
                // Sau khi đăng nhập thành công, chuyển hướng đến trang list.php
                header('Location: /qlsinhvien/HocPhan');
                exit();
            } else {
                // Nếu không tìm thấy mã sinh viên, hiển thị thông báo lỗi
                $error_message = "⚠ Mã sinh viên không tồn tại!";
                include 'app/views/sinhvien/login.php'; // Hiển thị lại trang login và thông báo lỗi
            }
        } else {
            // Hiển thị form đăng nhập nếu chưa có dữ liệu POST
            include 'app/views/sinhvien/login.php';
        }
    }
    

    // Hiển thị thông tin chi tiết của một sinh viên
    public function infor($id)
{
    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($id);

    // Nếu sinh viên không tồn tại, hiển thị thông báo lỗi
    if (!$sinhVien) {
        echo "Không tìm thấy sinh viên với ID này.";
        return;
    }

    // Chuyển đến trang infor.php để hiển thị chi tiết sinh viên
    include 'app/views/sinhvien/infor.php';
}


    // Thêm sinh viên
    public function add()
    {
        $nganhHocs = (new NganhHocModel($this->db))->getNganhHocs();
        include 'app/views/sinhvien/add.php';
    }

    // Lưu sinh viên mới vào cơ sở dữ liệu
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maSV = $_POST['maSV'] ?? '';
            $hoTen = $_POST['hoTen'] ?? '';
            $gioiTinh = $_POST['gioiTinh'] ?? '';
            $ngaySinh = $_POST['ngaySinh'] ?? '';
            $hinh = $_FILES['hinh'] ?? null;
            $maNganh = $_POST['maNganh'] ?? null;
    
            $result = $this->sinhVienModel->addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh);
    
            if (is_array($result)) {
                $errors = $result;
                $nganhHocs = (new NganhHocModel($this->db))->getNganhHocs();
                include 'app/views/sinhvien/add.php';
            } else {
                header('Location: /qlsinhvien/SinhVien');
            }
        }
    }

    // Chỉnh sửa sinh viên
    public function edit($id)
    {
        $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($id);
        $nganhHocs = (new NganhHocModel($this->db))->getNganhHocs();

        if ($sinhVien) {
            include 'app/views/sinhvien/edit.php';
        } else {
            echo "Không thấy sinh viên.";
        }
    }

    // Cập nhật thông tin sinh viên
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['maSV'];
            $hoTen = $_POST['hoTen'];
            $gioiTinh = $_POST['gioiTinh'];
            $ngaySinh = $_POST['ngaySinh'];
            $maNganh = $_POST['maNganh'];
    
            // Xử lý hình ảnh nếu có
            $hinh = $_POST['current_image'];  // Lưu hình ảnh cũ nếu không thay đổi
            if (isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $imageTmpPath = $_FILES['hinh']['tmp_name'];
                $imageName = $_FILES['hinh']['name'];
                $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
    
                // Kiểm tra định dạng hình ảnh
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array(strtolower($imageExt), $allowedExts)) {
                    $imagePath = 'uploads/' . time() . '_' . $imageName;
                    move_uploaded_file($imageTmpPath, 'public/' . $imagePath);
    
                    // Cập nhật hình ảnh mới
                    $hinh = $imagePath;
                }
            }
    
            // Lấy thông tin sinh viên hiện tại từ cơ sở dữ liệu
            $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($maSV);
            $current_image = $sinhVien->Hinh;  // Lấy ảnh hiện tại

            // Sau đó gọi phương thức updateSinhVien với ảnh hiện tại nếu không có ảnh mới
            $result = $this->sinhVienModel->updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $current_image);

            if ($result) {
                header('Location: /qlsinhvien/SinhVien');
            } else {
                echo "Đã xảy ra lỗi khi lưu sinh viên.";
            }
        }
    }

    // Xóa sinh viên
    public function delete($id)
{
    // Kiểm tra nếu sinh viên tồn tại trong cơ sở dữ liệu
    $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($id);

    // Nếu sinh viên không tồn tại, trả về thông báo lỗi
    if (!$sinhVien) {
        echo "Không tìm thấy sinh viên với ID này.";
        return;
    }

    // Nếu sinh viên tồn tại, chuyển hướng đến trang delete.php để xác nhận xóa
    include 'app/views/sinhvien/delete.php';  // Gọi view delete.php để hiển thị thông tin sinh viên và yêu cầu xác nhận xóa
}
public function confirm_delete($id)
{
    // Kiểm tra nếu sinh viên tồn tại trong cơ sở dữ liệu
    $sinhVien = $this->sinhVienModel->getSinhVienByMaSV($id);

    // Nếu sinh viên không tồn tại, trả về thông báo lỗi
    if (!$sinhVien) {
        echo "Không tìm thấy sinh viên với ID này.";
        return;
    }

    // Thực hiện xóa sinh viên
    if ($this->sinhVienModel->deleteSinhVien($id)) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách sinh viên
        header('Location: /qlsinhvien/SinhVien');
        exit;  // Đảm bảo không có mã thêm vào sau khi redirect
    } else {
        // Nếu xóa thất bại, hiển thị thông báo lỗi
        echo "Đã xảy ra lỗi khi xóa sinh viên.";
    }
}



}
?>
