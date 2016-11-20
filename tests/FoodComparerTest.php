<?php

namespace vendor\project\tests\units;

require_once 'vendor/bin/atoum';

include_once 'public_html/classes/FoodComparer.php';

use \mageekguy\atoum;
use \vendor\project;

class FoodComparer extends atoum\test
{
    public function testSingleFood()
    {
        $foodComparer = new project\FoodComparer("Normal","Normal","Normal","Normal","Normal");

        $food1 = array(
            "food_id" => "123",
            "food_name" => "Panini",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "50",
            "cholesterol" => "12", //mg
            "calories" => "111", // kcal
            "fat" => "19", // grams
            "protein" => "3", // grams
            "sodium" => "102", // mg
            "carbohydrate" => "3", // grams
            "sugar" => "12", // grams
            "calcium" => "3" // ???
        );

        $sortedFoodDatas = $foodComparer->getHealthiestFood(array($food1), true);

        $this->string($sortedFoodDatas[0]['food_name'])->isEqualTo('Panini');
        $this->string($sortedFoodDatas[0]['food_id'])->isEqualTo('123');
    }

    public function testAppleVsFriedChicken()
    {
        // Fill in code
    }

    public function testThreeFoods()
    {
        // Fill in code
    }

    public function testAllHigh()
    {
        // Fill in code
    }

    public function testAllLow()
    {
        // Fill in code
    }

    public function testMixHighLow()
    {
        // Fill in code
    }

    public function testOzAndGrams()
    {
        // Fill in code
    }

    public function testNonNormalized() {
        // Fill in code
    }
}
?>
