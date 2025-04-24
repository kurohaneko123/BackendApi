<?php
require '../config/database.php';

// Import Models, Services, Controllers
require '../src/Models/Drink.php';
require '../src/Services/DrinkService.php';
require '../src/Controllers/DrinkController.php';

require '../src/Models/User.php';
require '../src/Services/UserService.php';
require '../src/Controllers/UserController.php';

require '../src/Models/Order.php';
require '../src/Services/OrderService.php';
require '../src/Controllers/OrderController.php';

require '../src/Models/Cart.php';
require '../src/Services/CartService.php';
require '../src/Controllers/CartController.php';

require '../src/Models/Feedback.php';
require '../src/Services/FeedbackService.php';
require '../src/Controllers/FeedbackController.php';

require '../src/Controllers/AuthController.php';
require '../src/Models/Zalo.php';
require '../src/Services/ZaloService.php';
require '../src/Controllers/ZaloController.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Đọc JSON data từ Flutter
$data = json_decode(file_get_contents("php://input"), true);
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getDrinks':
        $ctl = new \App\Controllers\DrinkController();
        $ctl->getAllDrinks();
        break;

    case 'login':
        $ctl = new \App\Controllers\AuthController();
        $ctl->login($data);
        break;

    case 'register':
        $ctl = new \App\Controllers\AuthController();
        $ctl->register($data);
        break;

    case 'createOrder':
        $ctl = new \App\Controllers\OrderController();
        $ctl->createOrder($data);
        break;

    case 'getOrders':
        $ctl = new \App\Controllers\OrderController();
        $ctl->getOrdersByUser($data);
        break;

    case 'getCart':
        $ctl = new \App\Controllers\CartController();
        $ctl->getCartItems($data);
        break;

    case 'addFeedback':
        $ctl = new \App\Controllers\FeedbackController();
        $ctl->addFeedback($data);
        break;

    case 'getFeedback':
        $ctl = new \App\Controllers\FeedbackController();
        $ctl->getFeedbackByDrink($data);
        break;

    case 'createPayment': // ✅ Tạo đơn ZaloPay
        $ctl = new \App\Controllers\ZaloController();
        $ctl->createPayment();
        break;

    case 'zaloCallback': // ✅ Nhận callback thanh toán từ Zalo
        $ctl = new \App\Controllers\ZaloController();
        $ctl->handleCallback();
        break;

    default:
        $ctl = new \App\Controllers\DrinkController();
        $ctl->getAllDrinks();
}
