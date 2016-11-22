<?php

namespace vendor\project;

require_once ('lib/fat-secret-php/src/Client.php');

require_once ('lib/fat-secret-php/src/OAuthBase.php');

require_once ('lib/fat-secret-php/src/FatSecretException.php');

class FoodFinder

{
    var $numberOfSearchTerms = 5;
    var $client;

    function __construct($consumerKey, $secretKey)
    {
        $this->client = new Client($consumerKey, $secretKey);
    }

    function runQuery($searchTerm)
    {
        // This initial search does not give us enough data. It only contains a
        // few basic facts like ID, sugar, some other stuff I forgot
        $searchResult = $this->client->SearchFood($searchTerm, false, false, $this->numberOfSearchTerms);

        // Keep track of all the IDs found by the search
        for ($i = 0; $i < $this->numberOfSearchTerms; $i++) {
            $foodIDs[$i] = $searchResult['foods']['food'][$i]['food_id'];
        }

        // Get the first food which has an actual serving size
        // Some items have a strange serving units (like 1 plate or something)
        for ($i = 0; $i < $this->numberOfSearchTerms; $i++) {
            $rawFoodData = $this->client->GetFood($foodIDs[$i]);
            $foodData = $this->getRelevantData($rawFoodData);
            if(isset($foodData)) {
                break;
            }
        }


        return $foodData;
    }

    function setNumberOfSearchTerms($num)
    {
        $this->numberOfSearchTerms = $num;
    }

    private
    function getRelevantData($rawFoodData)
    { // This is the case where the query contains multiple different ways of serving

        // If we went able to find something with a valid serving unit, 
        // we set the foodData to null so that whoever uses this knows
        // Eg, for fried chicken, yeild after cooking, bones removed, sliced, with bone, etc

        if ($rawFoodData["food"]["servings"]["serving"][0] !== null) {
            $metric_serving_unit = $rawFoodData["food"]["servings"]["serving"][0]["metric_serving_unit"];

            // Some restaurant items dont have a measurable serving size. We cant use these
            if ($metric_serving_unit != "g" && $metric_serving_unit != "oz") {
                return null;
            }

            return array(
                "food_id" => $rawFoodData["food"]["food_id"],
                "food_name" => $rawFoodData["food"]["food_name"],
                "metric_serving_amount" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["metric_serving_amount"], $metric_serving_unit),
                "cholesterol" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["cholesterol"], $metric_serving_unit), //mg
                "calories" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["calories"], $metric_serving_unit), // kcal
                "fat" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["fat"], $metric_serving_unit), // grams
                "protein" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["protein"], $metric_serving_unit), // grams
                "sodium" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["sodium"], $metric_serving_unit), // mg
                "carbohydrate" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["carbohydrate"], $metric_serving_unit), // grams
                "sugar" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["sugar"], $metric_serving_unit), // grams
                "calcium" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"][0]["calcium"], $metric_serving_unit) // ???
            );
        }

        // In this case, there is only one serving_description

        else {
            $metric_serving_unit = $rawFoodData["food"]["servings"]["serving"]["metric_serving_unit"];

            // Some restaurant items dont have a measurable serving size. We cant use these
            if ($metric_serving_unit != "g" && $metric_serving_unit != "oz") {
                return null;
            }

            return array(
                "food_id" => $rawFoodData["food"]["food_id"],
                "food_name" => $rawFoodData["food"]["food_name"],
                "metric_serving_amount" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["metric_serving_amount"], $metric_serving_unit),
                "cholesterol" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["cholesterol"], $metric_serving_unit), //mg
                "calories" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["calories"], $metric_serving_unit), // kcal
                "fat" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["fat"], $metric_serving_unit), // grams
                "protein" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["protein"], $metric_serving_unit), // grams
                "sodium" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["sodium"], $metric_serving_unit), // mg
                "carbohydrate" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["carbohydrate"], $metric_serving_unit), // grams
                "sugar" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["sugar"], $metric_serving_unit), // grams
                "calcium" => $this->convertToGrams($rawFoodData["food"]["servings"]["serving"]["calcium"], $metric_serving_unit) // ???
            );
        }
    }

    private function convertToGrams($amount, $servingUnit) {
        if ($servingUnit == "g") {
            return $amount;
        } else if ($servingUnit == "oz") {
            return $amount * 28.35;
        }
    }
}

?>
