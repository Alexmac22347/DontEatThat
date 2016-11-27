<?php

namespace vendor\project\tests\units;

require_once 'vendor/bin/atoum';

include_once 'public_html/classes/AutoCompleter.php';

use \mageekguy\atoum;
use \vendor\project;

class AutoCompleter extends atoum\test
{

    public function testApple() {
        $config = include('config/config.php');
        $autoCompleter = new project\AutoCompleter($config['consumer_key'], $config['secret_key']);

        $response = json_decode($autoCompleter->getSuggestions("App"), true);

        $this->string($response['suggestions']['suggestion'][0])->isEqualTo("apple");
        $this->string($response['suggestions']['suggestion'][1])->isEqualTo("apples");
        $this->integer(count($response['suggestions']['suggestion']))->isEqualTo(6);
    }

    public function testBanana() {
        $config = include('config/config.php');
        $autoCompleter = new project\AutoCompleter($config['consumer_key'], $config['secret_key']);
        
        $response = json_decode($autoCompleter->getSuggestions("Ban"), true);
        
        $this->string($response['suggestions']['suggestion'][0])->isEqualTo("banana");
        $this->string($response['suggestions']['suggestion'][1])->isEqualTo("bananas");
        $this->integer(count($response['suggestions']['suggestion']))->isEqualTo(6);
    }

    public function testSingleSuggestion() {
        
        $config = include('config/config.php');
        $autoCompleter = new project\AutoCompleter($config['consumer_key'], $config['secret_key']);
        
        $numSearchTerms = $autoCompleter->setNumSuggestions(1);
        
        $response = json_decode($autoCompleter->getSuggestions("pan"), true);
        
        $this->string($response['suggestions']['suggestion'])->isEqualTo("pancakes");
    }

    public function testTenSuggestions() {
        $config = include('config/config.php');
        $autoCompleter = new project\AutoCompleter($config['consumer_key'], $config['secret_key']);
        
        $numSearchTerms = $autoCompleter->setNumSuggestions(10);
        
        $response = json_decode($autoCompleter->getSuggestions("ap"), true);
        
        $this->string($response['suggestions']['suggestion'][0])->isEqualTo("apple");
        $this->integer(count($response['suggestions']['suggestion']))->isEqualTo(10);
    }
}

?>
