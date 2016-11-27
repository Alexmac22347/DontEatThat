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

    }

    public function testBanana() {

    }

    public function testSingleSuggestion() {

    }

    public function testTenSuggestions() {

    }

}


?>
