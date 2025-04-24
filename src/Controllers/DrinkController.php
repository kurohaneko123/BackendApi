<?php
namespace App\Controllers;

use App\Services\DrinkService;

class DrinkController {
    public function getAllDrinks(): void {
        $drinks = (new DrinkService())->getDrinks();
        echo json_encode(['success' => true, 'data' => $drinks]);
    }
}
