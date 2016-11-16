<?php

namespace vendor\project\tests\units;

require_once 'vendor/bin/atoum';

include_once 'public_html/classes/FoodFinder.php';

use \mageekguy\atoum;
use \vendor\project;

class FoodFinder extends atoum\test
{
    public function testSimpleQuery()
    {
        $config = include('config/config.php');
        $foodFinder = new project\FoodFinder($config['consumer_key'], $config['secret_key']);
        $dataArray = $foodFinder->runQuery('apple');
        $foodName = $dataArray['food_name'];
        $this->string($foodName)->isEqualTo("Apples");
    }

    public function testNullQuery()
    {
        // Fill in code
    }

    public function testMultipleSameQuery()
    {
        // Fill in code
    }

    public function testMultipleDifferentQuery()
    {
        // Fill in code
    }
}
?>
