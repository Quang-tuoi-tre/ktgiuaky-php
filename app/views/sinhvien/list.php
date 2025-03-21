<?php include __DIR__ . '/../shares/header.php'; ?>




<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .add-btn {
        display: block;
        width: 150px;
        padding: 10px;
        margin: 0 auto;
        background-color: #007bff;
        color: white;
        text-align: center;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .add-btn:hover {
        text-decoration: underline;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
   
    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
    }

    td a {
        color: #007bff;
        text-decoration: none;
        margin-right: 10px;
    }

    td a:hover {
        text-decoration: underline;
    }
    .actions {
        display: flex;
    }

    .student-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
</style>

<body>
    <div class="container">
        <h1>Danh sách Sinh Viên</h1>
        <a href="/qlsinhvien/SinhVien/add" class="add-btn">Thêm sinh viên mới</a>

        <table class="student-table">
            <thead>
                <tr>
                    <th>MaSV</th>
                    <th>HoTen</th>
                    <th>GioiTinh</th>
                    <th>NgaySinh</th>
                    <th>Hinh</th>
                    <th>MaNganh</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sinhViens as $sinhVien): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sinhVien->MaSV, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($sinhVien->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><img style="" src="/qlsinhvien/public/uploads/<?php echo $sinhVien->Hinh; ?>" alt="Student Image" class="student-img"></td>
                        <td><?php echo htmlspecialchars($sinhVien->MaNganh, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="actions">
                            <a href="/qlsinhvien/SinhVien/edit/<?php echo $sinhVien->MaSV; ?>" class="btn btn-warning">Sửa</a>
                            <a href="/qlsinhvien/SinhVien/delete/<?php echo $sinhVien->MaSV; ?>"
                               class="btn btn-danger"
                               >
                                Xóa
                            </a>
                            <a href="/qlsinhvien/SinhVien/infor/<?php echo $sinhVien->MaSV; ?>" class="btn btn-info">Chi tiết</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
