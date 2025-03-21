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
    }

    td a:hover {
        text-decoration: underline;
    }

    .register-btn {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .register-btn:hover {
        background-color: #218838;
    }
</style>

<body>
    <div class="container">
        <h1>Danh Sách Học Phần</h1>

        <table class="hocphan-table">
            <thead>
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Số Lượng Dự Kiến</th> Thêm cột số lượng dự kiến
                    <th>Đăng Ký</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhans as $hocPhan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hocPhan->MaHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->SoLuongDuKien, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><form action="/qlsinhvien/DangKy/addToCart" method="POST">
                            <input type="hidden" name="MaHP" value="<?php echo $hocPhan->MaHP; ?>">
                            <button type="submit" class="btn btn-success">Đăng Ký</button>
                        </form></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
