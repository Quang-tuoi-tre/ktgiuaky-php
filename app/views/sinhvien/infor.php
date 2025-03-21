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

    .student-info {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .student-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
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
        <h1>Thông tin chi tiết Sinh Viên</h1>

        <div class="student-info">
            <p><strong>HoTen:</strong> <?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>GioiTinh:</strong> <?php echo htmlspecialchars($sinhVien->GioiTinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>NgaySinh:</strong> <?php echo htmlspecialchars($sinhVien->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Hinh:</strong></p>
            <img src="/qlsinhvien/public/uploads/<?php echo $sinhVien->Hinh; ?>" alt="Student Image" class="student-img">
            <p><strong>MaNganh:</strong> <?php echo htmlspecialchars($sinhVien->MaNganh, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <a href="/qlsinhvien/SinhVien" class="btn-back">Back to List</a>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
