<?php
class DangKyModel
{
    private $db;
    private $tableDangKy = 'DangKy';
    private $tableChiTietDangKy = 'ChiTietDangKy';

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lưu thông tin đăng ký vào bảng DangKy
    public function addDangKy($maSV, $ngayDangKy)
    {
        var_dump($maSV); // Kiểm tra mã sinh viên
    var_dump($ngayDangKy);
        // Thêm thông tin đăng ký vào bảng DangKy
        $query = "INSERT INTO " . $this->tableDangKy . " (MaSV, NgayDK) VALUES (:maSV, :ngayDK)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':ngayDK', $ngayDangKy);
        $stmt->execute();

        // Trả về mã đăng ký vừa được tạo
        return $this->db->lastInsertId();
    }

    // Thêm chi tiết đăng ký vào bảng ChiTietDangKy
    public function addChiTietDangKy($maDK, $maHP)
    {
        var_dump($maDK); // Kiểm tra mã đăng ký
    var_dump($maHP);
        // Kiểm tra xem học phần đã có trong bảng ChiTietDangKy chưa
        $queryCheck = "SELECT COUNT(*) FROM " . $this->tableChiTietDangKy . " WHERE MaDK = :maDK AND MaHP = :maHP";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':maDK', $maDK);
        $stmtCheck->bindParam(':maHP', $maHP);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();
    
        // Nếu học phần chưa có trong bảng ChiTietDangKy, thì thêm
        if ($count == 0) {
            $query = "INSERT INTO " . $this->tableChiTietDangKy . " (MaDK, MaHP) VALUES (:maDK, :maHP)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':maDK', $maDK);
            $stmt->bindParam(':maHP', $maHP);
            $stmt->execute();
        }
    }
    

    // Lấy danh sách học phần đã đăng ký của sinh viên
    public function getHocPhanByMaSV($maSV)
    {
        // Lấy các học phần của sinh viên theo mã sinh viên
        $query = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi
                  FROM " . $this->tableDangKy . " dk
                  JOIN " . $this->tableChiTietDangKy . " ctdk ON dk.MaDK = ctdk.MaDK
                  JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                  WHERE dk.MaSV = :maSV";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();

        // Trả về danh sách các học phần đã đăng ký
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
