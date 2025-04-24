<?php
namespace App\Controllers;

use App\Services\ZaloService;

class ZaloController {
    public function createPayment() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);
        $amount = $data['amount'] ?? 0;
        $orderId = time(); // hoặc bạn có thể truyền từ frontend

        $service = new ZaloService();
        $result = $service->createPaymentOrder($amount, $orderId);

        if (isset($result['return_code']) && $result['return_code'] == 1 && isset($result['order_url'])) {
            echo json_encode([
                'return_code' => 1,
                'order_url' => $result['order_url']
            ]);
        } else {
            echo json_encode([
                'return_code' => 0,
                'message' => $result['return_message'] ?? 'Tạo đơn hàng thất bại',
                'debug' => $result
            ]);
        }
    }

    public function handleCallback() {
        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);

        file_put_contents(__DIR__ . '/../../logs/zalo_callback.log', date('Y-m-d H:i:s') . "\n" . print_r($data, true) . "\n", FILE_APPEND);

        // TODO: Xử lý cập nhật trạng thái đơn hàng trong DB tại đây nếu cần

        echo json_encode(['return_code' => 1, 'return_message' => 'Callback OK']);
    }
}