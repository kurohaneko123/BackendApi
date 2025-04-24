<?php
namespace App\Controllers;

use App\Services\CartService;

class CartController {
    private $cartService;
    public function __construct() {
        $this->cartService = new CartService();
    }

    // API lấy các mục giỏ hàng theo order (chi tiết đơn hàng)
    public function getCartItems() {
        $orderId = $_GET['order_id'] ?? 0;
        $items = $this->cartService->getItemsByOrder($orderId);
        echo json_encode($items);
    }
}
?>
