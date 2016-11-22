<?php
/**
 * public_html/classes/FoodComparer.php
 *
 * This class is used to compare a list of Foods to see
 * which is the healthiest. A higher score means a healthier food.
 *
 * @package default
 */


namespace vendor\project;

class FoodComparer {
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


    /**
     *
     * @param string $userCalories - Used to determine if the user wants more, less, or a normal amount of calories
     *                               "High" -> More calories create a higher score
     *                               "Low" -> More calories create a lower score
     *                               Any other string -> Calories are based of the amount an average person should eat in a day
     * @param string $userSugar - Used to determine if the user wants more, less, or a normal amount of sugar
     *                            "High" -> More sugar create a higher score
     *                            "Low" -> More sugar create a lower score
     *                             Any other string -> sugar is based of the amount an average person should eat in a day
     *
     * @param string $userSodium - Used to determine if the user wants more, less, or a normal amount of sodium
     *                            "High" -> More sodium create a higher score
     *                            "Low" -> More sodium create a lower score
     *                             Any other string -> sodium is based of the amount an average person should eat in a day
     *
     * @param string $userProtein - Used to determine if the user wants more, less, or a normal amount of protein
     *                            "High" -> More protein create a higher score
     *                            "Low" -> More protein create a lower score
     *                             Any other string -> protein is based of the amount an average person should eat in a day
     *
     * @param string $userCalcium - Used to determine if the user wants more, less, or a normal amount of calcium
     *                            "High" -> More calcium create a higher score
     *                            "Low" -> More calcium create a lower score
     *                             Any other string -> calcium is based of the amount an average person should eat in a day
     *
     */
    function __construct( $userCalories, $userSugar, $userSodium, $userProtein, $userCalcium ) {
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
    /**
     * The higher the score, the healthier the food
     *
     * @param array $foodDatas - An multidimensional array of food. Element should be an array of
     *                           information for a particular food
     * @param bool $useNormalizeWeights - Set this to true if you want to compare 100 grams
     *                                       of each food item. Set to false if you want to compare
     *                                       based on serving size.
     * @return array - The exact same array as $foodDatas, but each item has a new field called 'score'
     *                  'score' is a float. The higher the 'score', the healthier the food is.
     */
    function getScores( $foodDatas, $useNormalizeWeights ) {

        assert(count($foodDatas) >= 1);

        // Add the score field to each foodDatas element
        foreach ($foodDatas as &$foodData) {
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


    /**
     *
     * @param float $field - The field you want to normalize. This is a number. For example, number
     *                       of grams of protein, or milligrams of sodium.
     * @param float $servingSize - The serving size of the food. Eg, a banana weighs 80 grams, so you would put 80 in here.
     * @return The amount of $field per 100 grams (assuming serving size is in grams)
     */
    function normalizeWeight($field, $servingSize) {
        return round(($field / $servingSize) * 100);
    }


}


?>
