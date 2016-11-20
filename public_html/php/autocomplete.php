<?php
require_once('../classes/AutoCompleter.php');

$config = include('../../config/config.php');

$autoCompleter = new project\vendor\AutoCompleter($config['consumer_key'], $config['secret_key']);

$url  = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($url, 'item=1') !== false) {
    $searchTerm    = $_GET['item1'];
} else if (strpos($url, 'item=2') !== false) {
    $searchTerm    = $_GET['item2'];
}

echo $autoCompleter->getSuggestions($searchTerm);
?>
