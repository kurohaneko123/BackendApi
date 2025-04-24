<?php
namespace App\Services;

use App\Models\Cart;

class CartService {
    private $cartModel;
    public function __construct() {
        $this->cartModel = new Cart();
    }

    // Thêm item vào giỏ (sử dụng trong quá trình tạo order)
    public function addItem($orderId, $drinkId, $quantity) {
        return $this->cartModel->add($orderId, $drinkId, $quantity);
    }

    // Lấy danh sách item của một đơn hàng
    public function getItemsByOrder($orderId) {
        return $this->cartModel->getByOrder($orderId);
    }
}
?>
