<?php
namespace App\Models;

class Zalo {
    public function getConfig() {
        return [
            'app_id' => '64548',
            'key1' => 'tuvsnycqhQmVsVDcUGdRpkoBkURjJAoT', // ✅ Key1 thật
            'key2' => '*********', // 🔁 Thay bằng key2 thật nếu cần xác thực callback
            'endpoint' => 'https://openapi.zalopay.vn/v001/tpe/createorder',
            'callback_url' => 'https://backendapi-2-smwf.onrender.com/zalo/callback'
        ];
    }

    public function createOrderData($amount, $orderId) {
        $config = $this->getConfig();

        return [
            'app_id' => $config['app_id'],
            'app_trans_id' => date("ymd") . "_" . $orderId,
            'app_user' => "user123",
            'app_time' => round(microtime(true) * 1000),
            'amount' => $amount,
            'item' => json_encode([]),
            'description' => "Thanh toán đơn hàng #$orderId",
            'embed_data' => json_encode([
                'redirecturl' => 'https://yourdomain.com/thankyou'
            ])
        ];
    }

    public function createMac($data) {
        $config = $this->getConfig();
        $macStr = $config['app_id'] . "|" . $data['app_trans_id'] . "|" . $data['app_user'] . "|" . $data['amount'] . "|" . $data['app_time'] . "|" . $data['embed_data'] . "|" . $data['item'];
        return hash_hmac("sha256", $macStr, $config['key1']);
    }
}
