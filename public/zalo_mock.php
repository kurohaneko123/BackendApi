<?php
header("Content-Type: application/json");

// Mã QR tĩnh giả lập (giống như in trên quầy)
$fakeQR = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=MOC_THANH_TOAN_CAFE123';

$response = [
    'success' => true,
    'qr_url' => $fakeQR,
    'order_id' => 'MOCK_' . rand(10000, 99999),
    'amount' => $_POST['amount'] ?? 0,
    'message' => 'Mã QR thanh toán đã tạo thành công (giả lập).'
];

echo json_encode($response);
