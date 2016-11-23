<?php

namespace vendor\project\tests\units;

require_once 'vendor/bin/atoum';

include_once 'public_html/classes/FoodComparer.php';

use \mageekguy\atoum;
use \vendor\project;

class FoodComparer extends atoum\test
{

    /**
     *
     */
    public function testSingleFood() {
        $foodComparer = new project\FoodComparer( "Normal", "Normal", "Normal", "Normal", "Normal" );

        $food1 = array(
            "food_id" => "651090",
            "food_name" => "Ham & Swiss Panini",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "156.000",
            "cholesterol" => "45", //mg
            "calories" => "340", // kcal
            "fat" => "10", // grams
            "protein" => "23", // grams
            "sodium" => "1130", // mg
            "carbohydrate" => "42", // grams
            "sugar" => "1", // grams
            "calcium" => "15" // ???
        );

        $scoredFoodDatas = $foodComparer->getScores( array( $food1), true);

        // In this case, the score doesnt really matter because theres nothing
        // to compare it to
        $this->string($scoredFoodDatas[0]['food_name'])->isEqualTo('Ham & Swiss Panini');
    }


    /**
     *
     */
    public function testAppleVsFriedChicken() {
        $foodComparer = new project\FoodComparer("Normal","Normal","Normal","Normal","Normal");

        $apple = array(
            "food_id" => "35718",
            "food_name" => "Apples",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "125.000",
            "cholesterol" => "0", //mg
            "calories" => "65", // kcal
            "fat" => "0.21", // grams
            "protein" => "0.32", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "17.26", // grams
            "sugar" => "12.99", // grams
            "calcium" => "1" //
        );

        $chicken = array(
            "food_id" => "1653",
            "food_name" => "Baked or Fried Coated Chicken Breast with Skin",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "120.000",
            "cholesterol" => "88", //mg
            "calories" => "313", // kcal
            "fat" => "15.92", // grams
            "protein" => "29.36", // grams
            "sodium" => "340", // mg
            "carbohydrate" => "11.38", // grams
            "sugar" => "0.26", // grams
            "calcium" => "2" //
        );

        $scoredFoodDatas = $foodComparer->getScores(array($apple, $chicken), true);

        // scoredFoodDatas[0] is the apple, scoredFoodDatas[1] is the chicken
        // The apple should have a higher score than the fried chicken
        $this->float($scoredFoodDatas[0]['score'])->isGreaterThan($scoredFoodDatas[1]['score']);
    }


    /**
     *
     */
    public function testThreeFoods() {
        $foodComparer = new project\FoodComparer("Normal","Normal","Normal","Normal","Normal");

        $tuna = array(
            "food_id" => "38089",
            "food_name" => "Tuna Fish Salad",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "205.000",
            "cholesterol" => "27", //mg
            "calories" => "383", // kcal
            "fat" => "18.98", // grams
            "protein" => "32.88", // grams
            "sodium" => "824", // mg
            "carbohydrate" => "19.29", // grams
            "sugar" => NULL, // grams
            "calcium" => "4" //
        );

        $rice = array(
            "food_id" => "4501",
            "food_name" => "White Rice",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "158.000",
            "cholesterol" => "0", //mg
            "calories" => "204", // kcal
            "fat" => "0.44", // grams
            "protein" => "4.20", // grams
            "sodium" => "577", // mg
            "carbohydrate" => "44.08", // grams
            "sugar" => "0.08", // grams
            "calcium" => "2" //
        );

        $apple = array(
            "food_id" => "35718",
            "food_name" => "Apples",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "125.000",
            "cholesterol" => "0", //mg
            "calories" => "65", // kcal
            "fat" => "0.21", // grams
            "protein" => "0.32", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "17.26", // grams
            "sugar" => "12.99", // grams
            "calcium" => "1" //
        );

        $scoredFoodDatas = $foodComparer->getScores(array($apple, $tuna, $rice), true);

        $this->float($scoredFoodDatas[2]['score'])->isGreaterThan($scoredFoodDatas[0]['score']);
        $this->float($scoredFoodDatas[2]['score'])->isGreaterThan($scoredFoodDatas[1]['score']);

    }


    /**
     *
     */
    public function testAllHigh() {
        $foodComparer = new project\FoodComparer("High","High","High","High","High");

        $apple = array(
            "food_id" => "35718",
            "food_name" => "Apples",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "125.000",
            "cholesterol" => "0", //mg
            "calories" => "65", // kcal
            "fat" => "0.21", // grams
            "protein" => "0.32", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "17.26", // grams
            "sugar" => "12.99", // grams
            "calcium" => "1" //
        );

        $beef = array("food_id" => "1350",
            "food_name" => "Beef",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "28.350",
            "cholesterol" => "25", //mg
            "calories" => "82", // kcal
            "fat" => "5.54", // grams
            "protein" => "7.46", // grams
            "sodium" => "109", // mg
            "carbohydrate" => "0", // grams
            "sugar" => "0", // grams
            "calcium" => "0" //
        );

        $scoredFoodDatas = $foodComparer->getScores(array($beef, $apple), true);

        $this->float($scoredFoodDatas[0]['score'])->isGreaterThan($scoredFoodDatas[1]['score']);
    }


    public function testAllLow() {
        $foodComparer = new project\FoodComparer("Low","Low","Low","Low","Low");

        $cucumber = array(
            "food_id" => "36376",
            "food_name" => "Cucumber (with Peel)",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "52.000",
            "cholesterol" => "0", //mg
            "calories" => "8", // kcal
            "fat" => "0.06", // grams
            "protein" => "0.34", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "1.89", // grams
            "sugar" => "0.87", // grams
            "calcium" => "1" //
        );

        $chicken = array(
            "food_id" => "1653",
            "food_name" => "Baked or Fried Coated Chicken Breast with Skin",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "120.000",
            "cholesterol" => "88", //mg
            "calories" => "313", // kcal
            "fat" => "15.92", // grams
            "protein" => "29.36", // grams
            "sodium" => "340", // mg
            "carbohydrate" => "11.38", // grams
            "sugar" => "0.26", // grams
            "calcium" => "2" //
        );

        $scoredFoodDatas = $foodComparer->getScores(array($chicken, $cucumber), true);

        $this->float($scoredFoodDatas[1]['score'])->isGreaterThan($scoredFoodDatas[0]['score']);
    }


    public function testMixHighLow() {
        $foodComparer = new project\FoodComparer("High","Low","High","Low","High");

        $cucumber = array(
            "food_id" => "36376",
            "food_name" => "Cucumber (with Peel)",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "52.000",
            "cholesterol" => "0", //mg
            "calories" => "8", // kcal
            "fat" => "0.06", // grams
            "protein" => "0.34", // grams
            "sodium" => "1", // mg
            "carbohydrate" => "1.89", // grams
            "sugar" => "0.87", // grams
            "calcium" => "1" //
        );

        $tuna = array(
            "food_id" => "38089",
            "food_name" => "Tuna Fish Salad",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "205.000",
            "cholesterol" => "27", //mg
            "calories" => "383", // kcal
            "fat" => "18.98", // grams
            "protein" => "32.88", // grams
            "sodium" => "824", // mg
            "carbohydrate" => "19.29", // grams
            "sugar" => NULL, // grams
            "calcium" => "4" //
        );


        $scoredFoodDatas = $foodComparer->getScores(array($cucumber, $tuna), true);

        $this->float($scoredFoodDatas[1]['score'])->isGreaterThan($scoredFoodDatas[0]['score']);
    }


    public function testNonNormalized() {
        $foodComparer = new project\FoodComparer("Low","Low","Low","Low","Low");

        $tuna = array(
            "food_id" => "38089",
            "food_name" => "Tuna Fish Salad",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "205.000",
            "cholesterol" => "27", //mg
            "calories" => "383", // kcal
            "fat" => "18.98", // grams
            "protein" => "32.88", // grams
            "sodium" => "824", // mg
            "carbohydrate" => "19.29", // grams
            "sugar" => NULL, // grams
            "calcium" => "4" //
        );

        $chicken = array(
            "food_id" => "1653",
            "food_name" => "Baked or Fried Coated Chicken Breast with Skin",
            "metric_serving_unit" => "g",
            "metric_serving_amount" => "120.000",
            "cholesterol" => "88", //mg
            "calories" => "313", // kcal
            "fat" => "15.92", // grams
            "protein" => "29.36", // grams
            "sodium" => "340", // mg
            "carbohydrate" => "11.38", // grams
            "sugar" => "0.26", // grams
            "calcium" => "2" //
        );

        $scoredFoodDatas = $foodComparer->getScores(array($chicken, $tuna), false);

        $this->float($scoredFoodDatas[0]['score'])->isGreaterThan($scoredFoodDatas[1]['score']);

    }


}


?>
