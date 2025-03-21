<?php include __DIR__ . '/../shares/header.php'; ?>

<style>
    /* CSS cho trang delete.php */
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

    .student-info {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .student-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-back {
        background-color: #007bff;
        color: white;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn-back:hover {
        background-color: #0056b3;
    }
</style>

<body>
    <div class="container">
        <h1>XÓA THÔNG TIN</h1>
        <p>Are you sure you want to delete this student?</p>

        <div class="student-info">
            <p><strong>HoTen:</strong> <?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>GioiTinh:</strong> <?php echo htmlspecialchars($sinhVien->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>NgaySinh:</strong> <?php echo htmlspecialchars($sinhVien->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Hinh:</strong></p>
            <img src="/qlsinhvien/public/uploads/<?php echo $sinhVien->Hinh; ?>" alt="Student Image" class="student-img">
            <p><strong>MaNganh:</strong> <?php echo htmlspecialchars($sinhVien->MaNganh, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Xóa sinh viên -->
        <form action="/qlsinhvien/SinhVien/confirm_delete/<?php echo $sinhVien->MaSV; ?>" method="POST">
            <input type="submit" value="Delete" class="btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">
        </form>

        <!-- Quay lại danh sách sinh viên -->
        <a href="/qlsinhvien/SinhVien" class="btn-back">Back to List</a>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
