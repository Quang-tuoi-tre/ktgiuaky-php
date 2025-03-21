<?php
class HocPhanModel
{
    private $db;
    private $table = 'HocPhan';

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy tất cả học phần
    public function getAllHocPhan()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy thông tin học phần theo Mã học phần
    public function getHocPhanByMaHP($maHP)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE MaHP = :maHP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function updateSoLuongDuKien($maHP)
    {
        $query = "UPDATE " . $this->table . " SET SoLuongDuKien = SoLuongDuKien - 1 WHERE MaHP = :maHP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':maHP', $maHP);
        $stmt->execute();
    }
}
?>
