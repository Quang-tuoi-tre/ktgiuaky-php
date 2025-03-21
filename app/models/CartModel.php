<?php
class CartModel
{
    public function getCart()
    {
        // Trả về giỏ hàng từ session
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    public function addToCart($hocPhan)
    {
        // Thêm học phần vào giỏ hàng
        $_SESSION['cart'][] = $hocPhan;
    }

    public function removeFromCart($maHP)
    {
        // Loại bỏ học phần khỏi giỏ hàng
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $hocPhan) {
                if ($hocPhan->MaHP === $maHP) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
        }
    }

    public function clearCart()
    {
        // Xóa tất cả các học phần trong giỏ hàng
        unset($_SESSION['cart']);
    }
}
?>
