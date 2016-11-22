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
    // sorted by healthiness. Note: everything is converted to grams here.
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

            $calories    = $this->convertToGrams($foodData['calories'], $foodData['metric_serving_unit']); // bad
            $carbs       = $this->convertToGrams($foodData['carbohydrate'], $foodData['metric_serving_unit']); // good
            $protein     = $this->convertToGrams($foodData['protein'], $foodData['metric_serving_unit']); // good
            $fat         = $this->convertToGrams($foodData['fat'], $foodData['metric_serving_unit']); // bad
            $cholesterol = $this->convertToGrams($foodData['cholesterol'], $foodData['metric_serving_unit']); // bad
            $sodium      = $this->convertToGrams($foodData['sodium'], $foodData['metric_serving_unit']); // bad
            $sugar       = $this->convertToGrams($foodData['sugar'], $foodData['metric_serving_unit']); // bad
            $calcium     = $this->convertToGrams($foodData['calcium'], $foodData['metric_serving_unit']); // good

            if ($useNormalizeWeights) {
                $servingSizeGrams = $this->convertToGrams($foodData['metric_serving_amount'], $foodData['metric_serving_unit']);

                $calories    = $this->normalizeWeight($calories, $servingSizeGrams);
                $carbs       = $this->normalizeWeight($carbs, $servingSizeGrams);
                $protein     = $this->normalizeWeight($protein, $servingSizeGrams);
                $fat         = $this->normalizeWeight($fat, $servingSizeGrams);
                $cholesterol = $this->normalizeWeight($cholesterol, $servingSizeGrams);
                $sodium      = $this->normalizeWeight($sodium, $servingSizeGrams);
                $sugar       = $this->normalizeWeight($sugar, $servingSizeGrams);
                $calcium     = $this->normalizeWeight($calcium, $servingSizeGrams);
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


    function convertToGrams($amount, $servingUnit) {
        if ($servingUnit == "g") {
            return $amount;
        } else if ($servingUnit == "oz") {
            return $amount * 28.35;
        }
    }

    function normalizeWeight($field, $servingSize) {
        return round(($field / $servingSize) * 100);
    }

}

?>
