<?php
namespace App\Controllers;

use App\Services\UserService;

class AuthController {
    public function login($data) {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $userService = new UserService();
        $user = $userService->loginUser($email, $password);

        if ($user['success']) {
            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'user' => $user['user']
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $user['message'] ?? 'Sai email hoặc mật khẩu.'
            ]);
        }
    }

    public function register($data) {
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $userService = new UserService();
        $result = $userService->registerUser($name, $email, $password);

        echo json_encode($result);
    }
}
?>
