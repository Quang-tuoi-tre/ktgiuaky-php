<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container">
    <h1>Đăng Ký học phần</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Mã Học Phần</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $hocPhan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hocPhan->MaHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div>
        <p><strong>Số lượng học phần:</strong> <?php echo count($_SESSION['cart']); ?></p>
        <p><strong>Tổng số tín chỉ:</strong>
            <?php 
                $totalCredits = array_sum(array_map(function($hocPhan) {
                    return $hocPhan->SoTinChi;
                }, $_SESSION['cart']));
                echo $totalCredits;
            ?>
        </p>
    </div>

    <div class="student-info">
        <h3>Thông tin Đăng Ký</h3>
        <p><strong>Mã số sinh viên:</strong> <?php echo htmlspecialchars($sinhVien->MaSV, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Họ Tên Sinh Viên:</strong> <?php echo htmlspecialchars($sinhVien->HoTen, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Ngày Sinh:</strong> <?php echo htmlspecialchars($sinhVien->NgaySinh, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Ngành Học:</strong> <?php echo htmlspecialchars($sinhVien->MaNganh, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Ngày Đăng Ký:</strong> <?php echo date('m/d/Y'); ?></p>
    </div>

    <form action="/qlsinhvien/DangKy/confirmRegister" method="POST">
        <button type="submit" class="btn btn-primary">Xác Nhận</button>
    </form>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>
