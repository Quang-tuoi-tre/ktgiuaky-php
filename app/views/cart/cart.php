<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container">
    <h1>Giỏ Hàng Học Phần</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $hocPhan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hocPhan->MaHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->TenHP, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($hocPhan->SoTinChi, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="/qlsinhvien/Cart/removeFromCart/<?php echo $hocPhan->MaHP; ?>" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div>
            <p><strong>Số học phần:</strong> <?php echo count($_SESSION['cart']); ?></p>
            <p><strong>Tổng số tín chỉ:</strong> 
                <?php 
                    $totalCredits = array_sum(array_map(function($hocPhan) {
                        return $hocPhan->SoTinChi;
                    }, $_SESSION['cart']));
                    echo $totalCredits;
                ?>
            </p>
        </div>

        <form action="/qlsinhvien/DangKy/registerCart" method="POST">
            <button type="submit" class="btn btn-primary">Lưu đăng ký</button>
        </form>

        <form action="/qlsinhvien/Cart/clearCart" method="POST">
            <button type="submit" class="btn btn-danger">Xóa Đăng Ký</button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>
