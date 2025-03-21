<?php
class NganhHocModel
{
    private $conn;
    private $table_name = "NganhHoc";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả các ngành học
    public function getNganhHocs()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);  // Trả về kết quả dưới dạng đối tượng
        return $result;
    }

    // Lấy ngành học theo mã
 
}
?>
