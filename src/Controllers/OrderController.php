<?php
namespace App\Controllers;

use App\Services\OrderService;

class OrderController {
    private $orderService;
    public function __construct() {
        $this->orderService = new OrderService();
    }

    // API tạo đơn hàng mới
    public function createOrder() {
        // Dữ liệu đầu vào (JSON hoặc POST): user_id và danh sách items
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['user_id'] ?? 0;
        $items = $data['items'] ?? [];  // dạng mảng: [ {"drink_id":..., "quantity":...}, ... ]
        $result = $this->orderService->createOrder($userId, $items);
        echo json_encode($result);
    }

    // API lấy danh sách đơn hàng theo user (history)
    public function getOrdersByUser() {
        // Giả định truyền user_id qua query string
        $userId = $_GET['user_id'] ?? 0;
        $orders = $this->orderService->getOrdersByUser($userId);
        echo json_encode($orders);
    }
}
?>
