<?php
require_once ('lib/fat-secret-php/src/Client.php');

require_once ('lib/fat-secret-php/src/OAuthBase.php');

require_once ('lib/fat-secret-php/src/FatSecretException.php');

class FoodFinder

{
    var $numberOfSearchTerms = 5;
    var $client;

    function __construct($consumerKey, $secretKey)
    {
        $this->client = new Adcuz\FatSecret\Client($consumerKey, $secretKey);
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
        // Some items have a strange serving units
        for ($i = 0; $i < $this->numberOfSearchTerms; $i++) {
            $rawFoodData = $this->client->GetFood($foodIDs[$i]);
            $foodData = $this->getRelevantData($rawFoodData);
            if ($foodData['metric_serving_unit'] == 'g' || $this->foodData1['metric_serving_unit'] == 'oz') {
                break;
            }
        }

        // If we went able to find something with a valid serving unit, 
        // we set the foodData to null so that whoever uses this knows
        if ($foodData['metric_serving_unit'] != 'g' && $this->foodData1['metric_serving_unit'] != 'oz') {
            $foodData = null;
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

        // Eg, for fried chicken, yeild after cooking, bones removed, sliced, with bone, etc

        if ($rawFoodData["food"]["servings"]["serving"][0] !== null) {
            return array(
                "food_id" => $rawFoodData["food"]["food_id"],
                "food_name" => $rawFoodData["food"]["food_name"],
                "metric_serving_unit" => $rawFoodData["food"]["servings"]["serving"][0]["metric_serving_unit"],
                "metric_serving_amount" => $rawFoodData["food"]["servings"]["serving"][0]["metric_serving_amount"],
                "cholesterol" => $rawFoodData["food"]["servings"]["serving"][0]["cholesterol"], //mg
                "calories" => $rawFoodData["food"]["servings"]["serving"][0]["calories"], // kcal
                "fat" => $rawFoodData["food"]["servings"]["serving"][0]["fat"], // grams
                "protein" => $rawFoodData["food"]["servings"]["serving"][0]["protein"], // grams
                "sodium" => $rawFoodData["food"]["servings"]["serving"][0]["sodium"], // mg
                "carbohydrate" => $rawFoodData["food"]["servings"]["serving"][0]["carbohydrate"], // grams
                "sugar" => $rawFoodData["food"]["servings"]["serving"][0]["sugar"] // grams
            );
        }

        // In this case, there is only one serving_description

        else {
            return array(
                "food_id" => $rawFoodData["food"]["food_id"],
                "food_name" => $rawFoodData["food"]["food_name"],
                "metric_serving_unit" => $rawFoodData["food"]["servings"]["serving"]["metric_serving_unit"],
                "metric_serving_amount" => $rawFoodData["food"]["servings"]["serving"]["metric_serving_amount"],
                "cholesterol" => $rawFoodData["food"]["servings"]["serving"]["cholesterol"], //mg
                "calories" => $rawFoodData["food"]["servings"]["serving"]["calories"], // kcal
                "fat" => $rawFoodData["food"]["servings"]["serving"]["fat"], // grams
                "protein" => $rawFoodData["food"]["servings"]["serving"]["protein"], // grams
                "sodium" => $rawFoodData["food"]["servings"]["serving"]["sodium"], // mg
                "carbohydrate" => $rawFoodData["food"]["servings"]["serving"]["carbohydrate"], // grams
                "sugar" => $rawFoodData["food"]["servings"]["serving"]["sugar"] // grams
            );
        }
    }
}

?>
