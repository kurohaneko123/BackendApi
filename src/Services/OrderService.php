<?php
namespace App\Services;

use App\Models\Order;
use App\Services\CartService;
use App\Models\Drink;  // để lấy giá đồ uống khi tính tổng (giả sử có model Drink)

class OrderService {
    private $orderModel;
    private $cartService;
    private $drinkModel;
    public function __construct() {
        $this->orderModel = new Order();
        $this->cartService = new CartService();
        $this->drinkModel = new Drink();
    }

    // Tạo đơn hàng mới từ danh sách item trong giỏ
    // $items là mảng các mục giỏ hàng, mỗi mục gồm drink_id và quantity
    public function createOrder($userId, $items) {
        // Bước 1: tạo một đơn hàng rỗng trước
        $orderId = $this->orderModel->create($userId);
        if (!$orderId) {
            return ["success" => false, "message" => "Không tạo được đơn hàng"];
        }
        // Bước 2: Thêm từng item vào bảng cart
        $total = 0;
        foreach ($items as $item) {
            $drinkId = $item['drink_id'];
            $qty = $item['quantity'];
            $this->cartService->addItem($orderId, $drinkId, $qty);
            // Tính tiền cho từng mục (giả định bảng drinks có cột price)
            $drink = $this->drinkModel->getById($drinkId);
            if ($drink) {
                $price = $drink['price'];
                $total += $price * $qty;
            }
        }
        // Bước 3: Cập nhật tổng tiền cho đơn hàng
        $this->orderModel->updateTotal($orderId, $total);
        return ["success" => true, "order_id" => $orderId];
    }

    // Lấy danh sách đơn hàng của một người dùng
    public function getOrdersByUser($userId) {
        return $this->orderModel->getByUser($userId);
    }
}
?>
