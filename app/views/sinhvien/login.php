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
        width: 50%;
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

    .form-group {
        margin-bottom: 15px;
    }

    label {
        font-size: 16px;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 10px;
        color: #007bff;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
    }
</style>

<body>
    <div class="container">
        <h1>ĐĂNG NHẬP</h1>

        <form action="/qlsinhvien/SinhVien/login" method="POST">
            <div class="form-group">
                <label for="MaSV">MaSV</label>
                <input type="text" id="MaSV" name="MaSV" placeholder="Nhập mã sinh viên" required>
            </div>

            <button type="submit">Đăng Nhập</button>
        </form>

        <!-- Hiển thị thông báo lỗi nếu mã sinh viên không tồn tại -->
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <a href="/qlsinhvien/SinhVien" class="back-link">Back to List</a>
    </div>
</body>

<?php include __DIR__ . '/../shares/footer.php'; ?>
