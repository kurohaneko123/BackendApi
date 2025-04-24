<?php
namespace App\Models;

class Zalo {
    private $config;

    public function __construct() {
        $this->config = [
            'appid' => '64548', // ✅ AppID từ ZaloPay
            'key1' => '*********', // ✅ Key1 từ ZaloPay
            'key2' => '*********', // ✅ Key2 từ ZaloPay (dùng cho xác minh callback)
            'endpoint' => 'https://sandbox.zalopay.com.vn/v001/tpe/createorder',
        ];
    }

    public function getConfig() {
        return $this->config;
    }

    public function createOrderData($amount, $orderId) {
        $app_trans_id = date("ymd") . "_" . $orderId;
        $app_time = round(microtime(true) * 1000);

        // ✅ Dữ liệu JSON đúng format, không có ký tự unicode escape
        $embed_data = json_encode([
            "redirecturl" => "https://yourdomain.com/thankyou"
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $items = json_encode([
            [
                "itemid" => "sp001",
                "itemname" => "Cà phê",
                "itemprice" => $amount,
                "itemquantity" => 1
            ]
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return [
            'app_id' => $this->config['appid'],
            'app_trans_id' => $app_trans_id,
            'app_user' => 'user123',
            'app_time' => $app_time,
            'amount' => $amount,
            'item' => $items,
            'embed_data' => $embed_data,
            'description' => "Thanh toán đơn hàng #$orderId",
        ];
    }

    public function createMac($data) {
        $mac_data = implode("|", [
            $data['app_id'],
            $data['app_trans_id'],
            $data['app_user'],
            $data['amount'],
            $data['app_time'],
            $data['embed_data'],
            $data['item']
        ]);
    
        // ✅ Ghi log đúng đường dẫn
        $logDir = realpath(__DIR__ . '/../..') . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
    
        file_put_contents($logDir . '/debug_mac.txt', $mac_data . PHP_EOL, FILE_APPEND);
    
        return hash_hmac("sha256", $mac_data, $this->config['key1']);
    }
    
    
}
