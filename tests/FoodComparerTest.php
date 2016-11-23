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

        $scoredFoodDatas = $foodComparer->getScores(array($food1), true);

        // In this case, the score doesnt really matter because theres nothing
        // to compare it to
        $this->string($scoredFoodDatas[0]['food_name'])->isEqualTo('Panini');
    }

    public function testAppleVsFriedChicken()
    {
        $foodComparer = new project\FoodComparer("Normal","Normal","Normal","Normal","Normal");

        $apple = array(
            "food_id" => "123",
            "food_name" => "Apple",
            "metric_serving_amount" => "125",
            "cholesterol" => "0", //mg
            "calories" => "65", // kcal
            "fat" => "0", // grams
            "protein" => "0", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "17", // grams
            "sugar" => "13", // grams
            "calcium" => "1" // ???
        );

        $friedChicken = array(
            "food_id" => "321",
            "food_name" => "Baked or Fried Chicken Breast with Skin",
            "metric_serving_amount" => "120",
            "cholesterol" => "88", //mg
            "calories" => "313", // kcal
            "fat" => "16", // grams
            "protein" => "29", // grams
            "sodium" => "340", // mg
            "carbohydrate" => "11", // grams
            "sugar" => "0", // grams
            "calcium" => "2" // ???
        );

        $scoredFoodDatas = $foodComparer->getScores(array($apple, $friedChicken), true);

        // scoredFoodDatas[0] is the apple, scoredFoodDatas[1] is the chicken
        // The apple should have a higher score than the fried chicken
        $this->float($scoredFoodDatas[0]['score'])->isGreaterThan($scoredFoodDatas[1]['score']);
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

    public function testNonNormalized() {
        // Fill in code
    }
}
?>
