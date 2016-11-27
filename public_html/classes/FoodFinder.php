<?php
/**
 * public_html/classes/FoodFinder.php
 *
 * This is a wrapper class for the FatSecret API. It filters out 
 * unnecessary information.
 *
 * @package default
 */


namespace vendor\project;

require_once 'lib/fat-secret-php/src/Client.php';

require_once 'lib/fat-secret-php/src/OAuthBase.php';

require_once 'lib/fat-secret-php/src/FatSecretException.php';

class FoodFinder {
    var $numberOfSearchTerms = 5;
    var $client;


    /**
     *
     * @param string $consumerKey - API consumer key, provided by FatSecret
     * @param string $secretKey - API secret key, provided by FatSecret
     */
    function __construct( $consumerKey, $secretKey ) {
        $this->client = new Client( $consumerKey, $secretKey );
    }


    /**
     *
     * @param string $searchTerm - The name of the food you want to search for. Eg, 'Apple'
     * @return array - An array containing various nutritional information about
     *                 the food item.
     */
    function runQuery($searchTerm) {
        // This initial search does not give us enough data. It only contains a
        // few basic facts like ID, sugar, some other stuff I forgot
        $searchResult = $this->client->SearchFood($searchTerm, false, false, $this->numberOfSearchTerms);

        // If initial search failed, we're done
        if($searchResult['foods']['total_results'] == 0) {
            return null;
        }

        // Keep track of all the IDs found by the search
        for ($i = 0; $i < $this->numberOfSearchTerms; $i++) {
            $foodIDs[$i] = $searchResult['foods']['food'][$i]['food_id'];
        }

        // Get the first food which has an actual serving size
        // Some items have a strange serving units (like 1 plate or something)
        for ($i = 0; $i < $this->numberOfSearchTerms; $i++) {
            $rawFoodData = $this->client->GetFood($foodIDs[$i]);
            $foodData = $this->getRelevantData($rawFoodData);
            if (isset($foodData)) {
                break;
            }
        }


        return $foodData;
    }


    /**
     *
     * @param int $num - The number of items to search through when doing the API call.
     *                   By default this is 5. After 5 items, the items returned by the API
     *                   start to become less relevant.
     */
    function setNumberOfSearchTerms($num) {
        $this->numberOfSearchTerms = $num;
    }


    private function getRelevantData($rawFoodData) { // This is the case where the query contains multiple different ways of serving

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
                "calories" => $rawFoodData["food"]["servings"]["serving"][0]["calories"], // kcal
				"carbohydrate" => $rawFoodData["food"]["servings"]["serving"][0]["carbohydrate"], // grams
                "protein" => $rawFoodData["food"]["servings"]["serving"][0]["protein"], // grams
                "fat" => $rawFoodData["food"]["servings"]["serving"][0]["fat"], // grams
                "cholesterol" => $rawFoodData["food"]["servings"]["serving"][0]["cholesterol"], //mg
                "sodium" => $rawFoodData["food"]["servings"]["serving"][0]["sodium"], // mg
				"potassium" => $rawFoodData["food"]["servings"]["serving"][0]["potassium"], // mg
				"fiber" => $rawFoodData["food"]["servings"]["serving"][0]["fiber"], // mg
                "sugar" => $rawFoodData["food"]["servings"]["serving"][0]["sugar"], // grams
				"vitA" => $rawFoodData["food"]["servings"]["serving"][0]["vitamin_a"], // percentage of daily recommended value
				"vitC" => $rawFoodData["food"]["servings"]["serving"][0]["vitamin_c"], // percentage of daily recommended value
                "calcium" => $rawFoodData["food"]["servings"]["serving"][0]["calcium"], // percentage of daily recommended value
				"iron" => $rawFoodData["food"]["servings"]["serving"][0]["iron"] // percentage of daily recommended value
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
				"calories" => $rawFoodData["food"]["servings"]["serving"]["calories"], // kcal
				"carbohydrate" => $rawFoodData["food"]["servings"]["serving"]["carbohydrate"], // grams
                "protein" => $rawFoodData["food"]["servings"]["serving"]["protein"], // grams
                "fat" => $rawFoodData["food"]["servings"]["serving"]["fat"], // grams
                "cholesterol" => $rawFoodData["food"]["servings"]["serving"]["cholesterol"], //mg
                "sodium" => $rawFoodData["food"]["servings"]["serving"]["sodium"], // mg
				"potassium" => $rawFoodData["food"]["servings"]["serving"]["potassium"], // mg
				"fiber" => $rawFoodData["food"]["servings"]["serving"]["fiber"], // mg
                "sugar" => $rawFoodData["food"]["servings"]["serving"]["sugar"], // grams
				"vitA" => $rawFoodData["food"]["servings"]["serving"]["vitamin_a"], // percentage of daily recommended value
				"vitC" => $rawFoodData["food"]["servings"]["serving"]["vitamin_c"], // percentage of daily recommended value
                "calcium" => $rawFoodData["food"]["servings"]["serving"]["calcium"], // percentage of daily recommended value
				"iron" => $rawFoodData["food"]["servings"]["serving"]["iron"] // percentage of daily recommended value
				
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
