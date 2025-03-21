<?php
class SinhVienModel
{
    private $conn;
    private $table_name = "SinhVien";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả sinh viên
    public function getSinhViens()
    {
        $query = "SELECT s.MaSV, s.HoTen, s.GioiTinh, s.NgaySinh, s.Hinh, s.MaNganh, n.TenNganh 
                  FROM " . $this->table_name . " s
                  LEFT JOIN NganhHoc n ON s.MaNganh = n.MaNganh";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);  // Trả về kết quả dưới dạng đối tượng
        return $result;
    }

    // Lấy sinh viên theo ID
    public function getSinhVienByMaSV($maSV)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaSV = :maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_OBJ); // Trả về thông tin sinh viên
        }
    
        return null; 
    }

    // Thêm sinh viên
    public function addSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh)
    {
        $errors = [];
        if (empty($maSV)) {
            $errors['MaSV'] = 'Mã sinh viên không được để trống';
        }
        if (empty($hoTen)) {
            $errors['HoTen'] = 'Họ tên không được để trống';
        }
        if (empty($ngaySinh)) {
            $errors['NgaySinh'] = 'Ngày sinh không được để trống';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        // Xử lý file hình ảnh
        $imageName = null;
        if (isset($hinh) && $hinh['error'] === 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($hinh['type'], $allowedTypes)) {
                $imageName = time() . '-' . basename($hinh['name']);
                $uploadDir = __DIR__ . "/../../public/uploads/";
                move_uploaded_file($hinh['tmp_name'], $uploadDir . $imageName);
            } else {
                $errors['Hinh'] = 'Chỉ cho phép tải lên hình ảnh với định dạng JPG, PNG, GIF';
            }
        }

        // Nếu không có lỗi, thêm sinh viên vào database
        $query = "INSERT INTO " . $this->table_name . " (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                  VALUES (:maSV, :hoTen, :gioiTinh, :ngaySinh, :hinh, :maNganh)";
        $stmt = $this->conn->prepare($query);

        $maSV = htmlspecialchars(strip_tags($maSV));
        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));
        $ngaySinh = htmlspecialchars(strip_tags($ngaySinh));
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':hinh', $imageName);
        $stmt->bindParam(':maNganh', $maNganh);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cập nhật thông tin sinh viên
    public function updateSinhVien($maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $current_image)
    {
        // Kiểm tra nếu có ảnh mới
        if (!empty($hinh)) {
            $image_path = basename($hinh); // Đảm bảo đường dẫn ảnh đúng
        } else {
            $image_path = $current_image;  // Dùng ảnh hiện tại nếu không có ảnh mới
        }

        $query = "UPDATE " . $this->table_name . " SET HoTen=:hoTen, GioiTinh=:gioiTinh, NgaySinh=:ngaySinh, MaNganh=:maNganh, Hinh=:hinh WHERE MaSV=:maSV";
        $stmt = $this->conn->prepare($query);

        $hoTen = htmlspecialchars(strip_tags($hoTen));
        $gioiTinh = htmlspecialchars(strip_tags($gioiTinh));
        $ngaySinh = htmlspecialchars(strip_tags($ngaySinh));
        $maNganh = htmlspecialchars(strip_tags($maNganh));
        $image_path = htmlspecialchars(strip_tags($image_path));

        $stmt->bindParam(':maSV', $maSV);
        $stmt->bindParam(':hoTen', $hoTen);
        $stmt->bindParam(':gioiTinh', $gioiTinh);
        $stmt->bindParam(':ngaySinh', $ngaySinh);
        $stmt->bindParam(':maNganh', $maNganh);
        $stmt->bindParam(':hinh', $image_path);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa sinh viên
    public function deleteSinhVien($maSV)
    {
        // Lấy thông tin sinh viên để lấy tên file ảnh
        $sinhVien = $this->getSinhVienByMaSV($maSV);
        $image_path = $sinhVien->Hinh; // Lấy đường dẫn ảnh

        // Xóa ảnh khỏi thư mục uploads nếu có
        if (!empty($image_path) && file_exists(__DIR__ . '/../../public/uploads/' . $image_path)) {
            unlink(__DIR__ . '/../../public/uploads/' . $image_path); // Xóa ảnh
        }

        // Xóa bản ghi sinh viên khỏi cơ sở dữ liệu
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV=:maSV";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':maSV', $maSV);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
