<?php
namespace App\Services;
use App\Models\Drink;

class DrinkService {
    public function getDrinks() {
        $drinkModel = new Drink();
        return $drinkModel->getAll();
    }
}
?>
