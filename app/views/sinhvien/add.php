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

    form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    input[type="text"],
    input[type="date"],
    select,
    input[type="file"] {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #218838;
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
        <h1>THÊM SINH VIÊN</h1>
        <form action="/qlsinhvien/SinhVien/save" method="POST" enctype="multipart/form-data">
            <label for="maSV">MaSV</label>
            <input type="text" id="maSV" name="maSV" placeholder="Nhập Mã Sinh Viên" required>

            <label for="hoTen">HoTen</label>
            <input type="text" id="hoTen" name="hoTen" placeholder="Nhập Họ Tên" required>

            <label for="gioiTinh">GioiTinh</label>
            <select id="gioiTinh" name="gioiTinh" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>

            <label for="ngaySinh">NgaySinh</label>
            <input type="date" id="ngaySinh" name="ngaySinh" required>

            <label for="hinh">Hinh</label>
            <input type="file" id="hinh" name="hinh" required>

            <label for="maNganh">MaNganh</label>
            <select id="maNganh" name="maNganh" class="form-control" required>
                <?php foreach ($nganhHocs as $nganhHoc): ?>
                    <option value="<?php echo $nganhHoc->MaNganh; ?>">
                        <?php echo htmlspecialchars($nganhHoc->TenNganh, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
                
            </select>

            <input type="submit" value="Create">
        </form>

        <a href="/qlsinhvien/SinhVien" class="btn-back">Back to List</a>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
