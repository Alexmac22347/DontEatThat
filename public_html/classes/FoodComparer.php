<?php

namespace vendor\project;

class FoodComparer 
{
    const DAILYCALORIES    = 2500; // kcal
    const DAILYCARBS       = 300; // g
    const DAILYPROTEIN     = 50; // g
    const DAILYFAT         = 65; // g
    const DAILYCHOLESTEROL = 300; // mg
    const DAILYSODIUM      = 2400; // mg
    const DAILYPOTASSIUM   = 5000; // mg
    const DAILYFIBER       = 30; // g 
    const DAILYSUGAR       = 30; // g
    const DAILYVITA        = 100; // percentage
    const DAILYVITC        = 100; // percentage
    const DAILYCALCIUM     = 100; // percentage
    const DAILYIRON        = 100; // percentage

    var $userCalories;
    var $userSugar;
    var $userSodium;
    var $userProtein;
    var $userCalcium;


    function __construct($userCalories, $userSugar, $userSodium, $userProtein, $userCalcium) {
        $this->userCalories = $userCalories;
        $this->userSugar = $userSugar;
        $this->userSodium = $userSodium;
        $this->userProtein = $userProtein;
        $this->userCalcium = $userCalcium;
    }
    
    // This method compares multiple food items, and returns an array sorted of food items
    // sorted by healthiness.
    //
    // Input: foodDatas            - Array of different foods to be compared
    //        $useNormalizeWeights - set this to true if you want to compare 
    //                               100 grams of each item, and disregard the serving size
    //
    // Returns:                    - The foodDatas array will be returned, but each element will have a new field call "score"
    //                               The higher the score, the healthier the food
function getScores($foodDatas, $useNormalizeWeights) {

        assert(count($foodDatas) >= 1);

        // Add the score field to each foodDatas element
        foreach($foodDatas as &$foodData) {
            $foodData['score'] = 0.0;
        }

        foreach ($foodDatas as &$foodData) {

            $calories    = $foodData['calories']; // bad
            $carbs       = $foodData['carbohydrate']; // good
            $protein     = $foodData['protein']; // good
            $fat         = $foodData['fat']; // bad
            $cholesterol = $foodData['cholesterol']; // bad
            $sodium      = $foodData['sodium']; // bad
            $sugar       = $foodData['sugar']; // bad
            $calcium     = $foodData['calcium']; // good

            if ($useNormalizeWeights) {
                $calories    = $this->normalizeWeight($calories, $foodData['metric_serving_amount']);
                $carbs       = $this->normalizeWeight($carbs, $foodData['metric_serving_amount']);
                $protein     = $this->normalizeWeight($protein, $foodData['metric_serving_amount']);
                $fat         = $this->normalizeWeight($fat, $foodData['metric_serving_amount']);
                $cholesterol = $this->normalizeWeight($cholesterol, $foodData['metric_serving_amount']);
                $sodium      = $this->normalizeWeight($sodium, $foodData['metric_serving_amount']);
                $sugar       = $this->normalizeWeight($sugar, $foodData['metric_serving_amount']);
                $calcium     = $this->normalizeWeight($calcium, $foodData['metric_serving_amount']);
            }

            $caloriesScale = 1;
            $sugarScale    = 1;
            $sodiumScale   = 1;
            $proteinScale  = 1;
            $calciumScale  = 1;

            if ($this->userCalories == "High") {
                $caloriesScale = -10;
            }

            if ($this->userCalories == "Low") {
                $caloriesScale = 10;
            }

            if ($this->userSugar == "High") {
                $sugarScale = -10;
            }

            if ($this->userSugar == "Low") {
                $sugarScale = 10;
            }

            if ($this->userSodium == "High") {
                $sodiumScale = -10;
            }

            if ($this->userSodium == "Low") {
                $sodiumScale = 10;
            }

            if ($this->userProtein == "High") {
                $proteinScale = 10;
            }

            if ($this->userProtein == "Low") {
                $proteinScale = -10;
            }

            if ($this->userCalcium == "High") {
                $calciumScale = 10;
            }

            if ($this->userCalcium == "Low") {
                $calciumScale = -10;
            }
                
            
            $score = -($caloriesScale) * ($calories / FoodComparer::DAILYCALORIES) 
                + ($carbs / FoodComparer::DAILYCARBS) 
                + ($proteinScale) * ($protein / FoodComparer::DAILYPROTEIN) 
                - ($fat / FoodComparer::DAILYFAT) 
                - ($cholesterol / FoodComparer::DAILYCHOLESTEROL) 
                - ($sodiumScale) * ($sodium / FoodComparer::DAILYSODIUM) 
                - ($sugarScale) * ($sugar / FoodComparer::DAILYSUGAR) 
                + ($calciumScale) * ($calcium / FoodComparer::DAILYCALCIUM) ;

            $foodData['score'] = $score;
        }

        return $foodDatas;
    }

    function normalizeWeight($field, $servingSize) {
        return round(($field / $servingSize) * 100);
    }

}

?>
