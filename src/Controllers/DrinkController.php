<?php
namespace App\Controllers;
use App\Services\DrinkService;

class DrinkController {
    public function getAllDrinks() {
        $drinkService = new DrinkService();
        $drinks = $drinkService->getDrinks();
        echo json_encode($drinks);
    }
}
?>
