<?php
require_once('classes/FoodFinder.php');
require_once('classes/FoodComparer.php');
$config = include('../config/config.php');

session_start();

$foodFinder    = new vendor\project\FoodFinder($config['consumer_key'], $config['secret_key']);
$resultData[0] = $foodFinder->runQuery($_GET['item1']);
$resultData[1] = $foodFinder->runQuery($_GET['item2']);


// If both or one of the foods was not found
if (!isset($resultData[0]['food_id']) && !isset($resultData[1]['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item1'] . " or " . $_GET['item2'] . ".<br>";
    header('Location: countdown.php');
}
else if (!isset($resultData[0]['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item1']. ".<br>";
    header('Location: countdown.php');
}
else if (!isset($resultData[1]['food_id'])) {
    $_SESSION['countdown_message'] = "Sorry, we could not find " . $_GET['item2'] . ".<br>";
    header('Location: countdown.php');
}

// If both foods mapped to the same result
else if ($resultData[0]['food_id'] == $resultData[1]['food_id']) {
    $_SESSION['countdown_message'] = "Sorry, the items you entered were the same. Please enter two different food items.<br>";
    header('Location: countdown.php');
}

?>

<?php
$title = "Results";
include("layout/header.php");

?>
<!-- Reference: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_table_basic&stacked=h -->
<div style="padding-left: 5%;padding-right:5%;">
	<div class="container-fluid">
		<h2>Results</h2>
		<div style="padding-top: 30px;" class="table-responsive" align="center">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Item (100 g portions)</th>
						<th>Calories</th>
						<th>Fat</th>
						<th>Sugar</th>
						<th>Sodium</th>
						<th>Protein</th>
						<th>Cholesterol</th>
						<th>Carbohydrates</th>
					</tr>
				</thead>
				<?php


if (!isset($_SESSION['user_username'])) {
    $foodComparer = new vendor\project\FoodComparer("Normal", "Normal","Normal","Normal","Normal");
} else {
    $foodComparer = new vendor\project\FoodComparer($_SESSION['user_calories'], $_SESSION['user_sugar'], $_SESSION['user_sodium'], $_SESSION['user_protein'], $_SESSION['user_calcium']);
}

$scoredFoods = $foodComparer->getScores(array($resultData[0], $resultData[1]), true);

// variables used to highlight a food item
$highlight0 = "";
$highlight1 = "";

// logic to determine which food to highlight

if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
    $highlight0 = "success";
} else {
    $highlight1 = "success";
} 

$normalizedCaloriesFood0 = $foodComparer->normalizeWeight($resultData[0]['calories'], $resultData[0]['metric_serving_amount']);
$normalizedFatFood0 = $foodComparer->normalizeWeight($resultData[0]['fat'], $resultData[0]['metric_serving_amount']);
$normalizedSugarFood0 = $foodComparer->normalizeWeight($resultData[0]['sugar'], $resultData[0]['metric_serving_amount']);
$normalizedSodiumFood0 = $foodComparer->normalizeWeight($resultData[0]['sodium'], $resultData[0]['metric_serving_amount']);
$normalizedProteinFood0 = $foodComparer->normalizeWeight($resultData[0]['protein'], $resultData[0]['metric_serving_amount']);
$normalizedCholestrolFood0 = $foodComparer->normalizeWeight($resultData[0]['cholesterol'], $resultData[0]['metric_serving_amount']);
$normalizedCarbohydrateFood0 = $foodComparer->normalizeWeight($resultData[0]['carbohydrate'], $resultData[0]['metric_serving_amount']);

$normalizedCaloriesFood1 = $foodComparer->normalizeWeight($resultData[1]['calories'], $resultData[1]['metric_serving_amount']);
$normalizedFatFood1 = $foodComparer->normalizeWeight($resultData[1]['fat'], $resultData[1]['metric_serving_amount']);
$normalizedSugarFood1 = $foodComparer->normalizeWeight($resultData[1]['sugar'], $resultData[1]['metric_serving_amount']);
$normalizedSodiumFood1 = $foodComparer->normalizeWeight($resultData[1]['sodium'], $resultData[1]['metric_serving_amount']);
$normalizedProteinFood1 = $foodComparer->normalizeWeight($resultData[1]['protein'], $resultData[1]['metric_serving_amount']);
$normalizedCholestrolFood1 = $foodComparer->normalizeWeight($resultData[1]['cholesterol'], $resultData[1]['metric_serving_amount']);
$normalizedCarbohydrateFood1 = $foodComparer->normalizeWeight($resultData[1]['carbohydrate'], $resultData[1]['metric_serving_amount']);

echo '
               <tbody>
                 <tr class=' . $highlight0 . '>
                   <td>' . $resultData[0]['food_name'] . '</td>
                   <td>' . round($normalizedCaloriesFood0) . ' kcal</td>
                   <td>' . round($normalizedFatFood0) . ' g</td>
                   <td>' . round($normalizedSugarFood0) . ' g</td>
                   <td>' . round($normalizedSodiumFood0) . ' mg</td>
				   <td>' . round($normalizedProteinFood0) . ' g</td>
				   <td>' . round($normalizedCholestrolFood0) . ' mg</td>
				   <td>' . round($normalizedCarbohydrateFood0) . ' g</td>
                 </tr>
               
                 <tr class=' . $highlight1 . '>
                   <td>' . $resultData[1]['food_name'] . '</td>
                   <td>' . round($normalizedCaloriesFood1) . ' kcal</td>
                   <td>' . round($normalizedFatFood1) . ' g</td>
                   <td>' . round($normalizedSugarFood1) . ' g</td>
                   <td>' . round($normalizedSodiumFood1) . ' mg</td>
				   <td>' . round($normalizedProteinFood1) . ' g</td>
				   <td>' . round($normalizedCholestrolFood1) . ' mg</td>
				   <td>' . round($normalizedCarbohydrateFood1) . ' g</td>
                 </tr>
               </tbody>
               ';


?>
			</table>

		</div>

	</div>
</div>

	<div align="center">
	<?php

// print out the healthier food item
if (!isset($_SESSION['user_username'])) {
    if($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
    }
} else { // user logged in
    if($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
        echo '<p style="text-align: center;">'. 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">'. 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
    }
}

?>
	</div>

	<div style="padding-left: 5%;padding-right:5%;">
		<div class="container-fluid">
			<div style="padding-top: 30px;" class="table-responsive" align="center">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Item</th>
							<th>Serving Size</th>
							<th>Calories</th>
							<th>Fat</th>
							<th>Sugar</th>
							<th>Sodium</th>
							<th>Protein</th>
							<th>Cholesterol</th>
							<th>Carbohydrates</th>
						</tr>
					</thead>
					<?php

if (!isset($_SESSION['user_username'])) {
    $foodComparer = new vendor\project\FoodComparer("Normal", "Normal","Normal","Normal","Normal");
} else {
    $foodComparer = new vendor\project\FoodComparer($_SESSION['user_calories'], $_SESSION['user_sugar'], $_SESSION['user_sodium'], $_SESSION['user_protein'], $_SESSION['user_calcium']);
}

$scoredFoods = $foodComparer->getScores(array($resultData[0], $resultData[1]), false);

// variables used to highlight a food item
$highlight0 = "";
$highlight1 = "";

// logic to determine which food to highlight

if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
    $highlight0 = "success";
} else {
    $highlight1 = "success";
} 

echo '
               <tbody>
                 <tr class=' . $highlight0 . '>
                   <td>' . $resultData[0]['food_name'] . '</td>
                   <td>' . round($resultData[0]['metric_serving_amount']) . ' g </td>
                   <td>' . round($resultData[0]['calories']) . ' kcal</td>
                   <td>' . round($resultData[0]['fat']) . ' g</td>
                   <td>' . round($resultData[0]['sugar']) . ' g</td>
                   <td>' . round($resultData[0]['sodium']) . ' mg</td>
				   <td>' . round($resultData[0]['protein']) . ' g</td>
				   <td>' . round($resultData[0]['cholesterol']) . ' mg</td>
				   <td>' . round($resultData[0]['carbohydrate']) . ' g</td>
                 </tr>
               
                 <tr class=' . $highlight1 . '>
                   <td>' . $resultData[1]['food_name'] . '</td>
                   <td>' . round($resultData[1]['metric_serving_amount']) . ' g </td>
                   <td>' . round($resultData[1]['calories']) . ' kcal</td>
                   <td>' . round($resultData[1]['fat']) . ' g</td>
                   <td>' . round($resultData[1]['sugar']) . ' g</td>
                   <td>' . round($resultData[1]['sodium']) . ' mg</td>
				   <td>' . round($resultData[1]['protein']) . ' g</td>
				   <td>' . round($resultData[1]['cholesterol']) . ' mg</td>
				   <td>' . round($resultData[1]['carbohydrate']) . ' g</td>
                 </tr>
               </tbody>
               ';


?>
			</table>

		</div>

	</div>
</div>

	<div align="center">
	<?php

// print out the healthier food item
if (!isset($_SESSION['user_username'])) {
    if($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
        echo '<p style="text-align: center;">' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
    }
} else { // user logged in
    if($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
        echo '<p style="text-align: center;">'. 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">'. 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
    }
}

?>
<br><br>
<a href="index.php" type="submit" class="btn btn-primary">Change Food Items</a>

	<?php
include "layout/footer.php";
?>
