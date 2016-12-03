<?php
/**
 * public_html/classes/AutoCompleter.php
 *
 * Use this class to query the database and get autocomplete suggestions.
 * For example, 'App' autocomplete gives 'Apple', 'Apples', 'Apple Pie', etc
 *
 * @package default
 */


namespace vendor\project;

require_once 'FoodFinder.php';

class AutoCompleter {
    var $consumerKey;
    var $secretKey;
    var $numSuggestions = 6;
    var $format = 'json';
    var $foodFinder; // Needed to check if autocomplete term is valid


    /**
     *
     * @param string $consumerKey - API consumer key, provided by FatSecret
     * @param string $secretKey - API secret key, provided by FatSecret
     */
    function __construct( $consumerKey, $secretKey ) {
        $this->consumerKey = $consumerKey;
        $this->secretKey = $secretKey;
        $this->foodFinder = new FoodFinder($consumerKey, $secretKey);
    }


    /**
     *
     * @param int $num - The number of items to return.
     *                   By default this is 6.
     */
    function setNumSuggestions( $num ) {
        $this->numSuggestions = $num;
    }


    /**
     *
     * @param string $format - The format which the data is returned.
     *  q                      By default this is 'json'
     */
    function setFormat($format) {
        $this->format = $format;
    }


    /**
     *
     * This method returns a json object containing suggested autocomplete terms
     * for the $searchTerm string.
     * For example, $seachTerm = 'App' returns 'Apple', 'Apples', 'Apple Pie', etc
     *
     * @param string $searchTerm - The string which will be sent to the API
     * @return A json data object containing autocomplete results
     */
    function getSuggestions($searchTerm) {
        //Signature Base String
        //<HTTP Method>&<Request URL>&<Normalized Parameters>
        $base         = rawurlencode("GET") . "&";
        $base .= "http%3A%2F%2Fplatform.fatsecret.com%2Frest%2Fserver.api&";

        //sort params by abc....necessary to build a correct unique signature
        $params = "expression=$searchTerm&";
        $params .= "format=$this->format&";
        $params .= "max_results=$this->numSuggestions&";
        $params .= "method=foods.autocomplete&";
        $params .= "oauth_consumer_key=$this->consumerKey&";
        $params .= "oauth_nonce=".md5(mt_rand())."&";
        $params .= "oauth_signature_method=HMAC-SHA1&";
        $params .= "oauth_timestamp=" . time() . "&";
        $params .= "oauth_version=1.0";
        $params2 = rawurlencode($params);
        $base .= $params2;

        //encrypt it!
        $sig = base64_encode(hash_hmac('sha1', $base, "$this->secretKey&", true));

        //now get the search results and write them down
        $url = "http://platform.fatsecret.com/rest/server.api?" . $params . "&oauth_signature=" . rawurlencode($sig);

        list($output, $error, $info) = $this->loadFoods($url);

        $output = json_decode($output, true);
        $output = $this->filterOutUnusableFood($output);
        $output = json_encode($output);

        if ($error == 0) {
            if ($info['http_code'] == '200') {
                return $output;
            }
            else {
                die('Status INFO : ' . $info['http_code']);
                return null;
            }
        } else {
            die('Status ERROR : ' . $error);
            return null;
        }
    }

    private function filterOutUnusableFood($response) {
        $filteredArray = [];

        // If the array has more than one element
        if(isset($response['suggestions']['suggestion'][0])) {
            for ($i = 0; $i < $this->numSuggestions; $i++) {
                // This should be done asynchronously
                $foodData = $this->foodFinder->runQuery($response['suggestions']['suggestion'][$i]);
                if (isset($foodData)) {
                    array_push($filteredArray, $foodData['food_name']);
                }
            }
        }
        // Else, autocomplete only found one thing
        $foodData = $this->foodFinder->runQuery($response['suggestions']['suggestion']);
        if (isset($foodData)) {
            array_push($filteredArray, $foodData['food_name']);
        }

        // Filter out any copies
        $filteredArray = array_unique($filteredArray);

        return $filteredArray;

    }


    private function loadFoods($url) {

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        $error = curl_error($ch);

        $info = curl_getinfo($ch);
        // close curl resource to free up system resources
        curl_close($ch);

        return array(
            $output,
            $error,
            $info
        );
    }


}
