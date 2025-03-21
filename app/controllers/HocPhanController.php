<?php
require_once('app/models/HocPhanModel.php');
require_once('app/models/SinhVienModel.php');
require_once('app/config/database.php');

class HocPhanController
{
    private $hocPhanModel;
    private $db;

    public function __construct()
    {
        // Kết nối cơ sở dữ liệu
        $this->db = (new Database())->getConnection();

        // Khởi tạo model
        $this->hocPhanModel = new HocPhanModel($this->db);
    }

    // Hiển thị danh sách học phần
    public function index()
    {
        if (!isset($_SESSION['MaSV'])) {
            header('Location: /qlsinhvien/SinhVien/login');
            exit();
        }

        // Lấy danh sách các học phần
        $hocPhans = $this->hocPhanModel->getAllHocPhan();
        
        include 'app/views/hocphan/list.php'; // Hiển thị danh sách học phần
    }
}
?>
