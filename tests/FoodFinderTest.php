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
        $config = include('config/config.php');
        $foodFinder = new project\FoodFinder($config['consumer_key'], $config['secret_key']);
        $dataArray = $foodFinder->runQuery('jkldffsa');
        $this->variable($dataArray)->isNull();
    }

    public function testMultipleSameQuery()
    {
        $config = include('config/config.php');
        $foodFinder = new project\FoodFinder($config['consumer_key'], $config['secret_key']);
        $dataArray1 = $foodFinder->runQuery('orange');
        $dataArray2 = $foodFinder->runQuery('orange');
        $foodName1 = $dataArray1['food_name'];
        $foodName2 = $dataArray2['food_name'];
        $this->string($foodName1)->isEqualTo("Oranges");
        $this->string($foodName2)->isEqualTo("Oranges");
    }

    public function testMultipleDifferentQuery()
    {
        $config = include('config/config.php');
        $foodFinder = new project\FoodFinder($config['consumer_key'], $config['secret_key']);
        $dataArray1 = $foodFinder->runQuery('bacon');
        $dataArray2 = $foodFinder->runQuery('beef');
        $dataArray3 = $foodFinder->runQuery('chicken');
        $foodName1 = $dataArray1['food_name'];
        $foodName2 = $dataArray2['food_name'];
        $foodName3 = $dataArray3['food_name'];
        $this->string($foodName1)->isEqualTo("Bacon");
        $this->string($foodName2)->isEqualTo("Beef");
        $this->string($foodName3)->isEqualTo("Chicken Breast");
    }
}
?>
