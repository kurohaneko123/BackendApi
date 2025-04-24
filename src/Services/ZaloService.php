<?php
namespace App\Services;

use App\Models\Zalo;

class ZaloService {
    private $zaloModel;

    public function __construct() {
        $this->zaloModel = new Zalo();
    }

    public function createPaymentOrder($amount, $orderId) {
        $config = $this->zaloModel->getConfig();
        $order = $this->zaloModel->createOrderData($amount, $orderId);
        $order['mac'] = $this->zaloModel->createMac($order);

        $ch = curl_init($config['endpoint']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($order));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ⚠️ KHÔNG dùng ở production

        $result = curl_exec($ch);

        if ($result === false) {
            return [
                'return_code' => 0,
                'return_message' => 'Lỗi CURL: ' . curl_error($ch)
            ];
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}
