<?php

namespace project\vendor;

class AutoCompleter

{
    var $consumerKey;
    var $secretKey;
    var $numSuggestions = 6;
    var $format = 'json';

    function __construct($consumerKey, $secretKey)
    {
        $this->consumerKey = $consumerKey;
        $this->secretKey = $secretKey;
    }

    function setNumSuggestions($num) {
        $this->numSuggestions = $num;
    }

    function setFormat($format) {
        $this->format = $format;
    }

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
        $params .= "oauth_nonce=123&";
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
