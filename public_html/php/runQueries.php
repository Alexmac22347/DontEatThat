<?php
// The minimun difference between two food scores
// before they are considered the same
const MINDIFFERENCE = 0.03;
require_once('classes/FoodFinder.php');
$config = include('../config/config.php');

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

$foodFinder    = new vendor\project\FoodFinder($config['consumer_key'], $config['secret_key']);
$_SESSION['foodData0'] = $foodFinder->runQuery($_GET['item1']);
$_SESSION['foodData1'] = $foodFinder->runQuery($_GET['item2']);


// If an API error occured (eg, too many calls)
if (isset($_SESSION['foodData0']['error'])) {
    $_SESSION['countdown_message'] = $_SESSION['foodData0']['error']['message'] . "<br>";
    header('Location: countdown.php');
}
else if (isset($_SESSION['foodData1']['error'])) {
    $_SESSION['countdown_message'] = $_SESSION['foodData1']['error']['message'] . "<br>";
    header('Location: countdown.php');
}

// If both or one of the foods was not found
else if (!isset($_SESSION['foodData0']['food_id']) && !isset($_SESSION['foodData1']['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item1'] . " or " . $_GET['item2'] . ".<br>";
    header('Location: countdown.php');
}
else if (!isset($_SESSION['foodData0']['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item1']. ".<br>";
    header('Location: countdown.php');
}
else if (!isset($_SESSION['foodData1']['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item2'] . ".<br>";
    header('Location: countdown.php');
}

// If both foods mapped to the same result
else if ($_SESSION['foodData0']['food_id'] == $_SESSION['foodData1']['food_id']) {
    $_SESSION['countdown_message'] = "Sorry, the items you entered were the same. Please enter two different food items.<br>";
    header('Location: countdown.php');
}
?>
