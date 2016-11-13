<?php
session_start();
require_once('FoodFinder.php');

$foodFinder = new FoodFinder();
$resultData[0] = $foodFinder->runQuery($_GET['item1']);
$resultData[1] = $foodFinder->runQuery($_GET['item2']);
$_SESSION['food0_id'] = $resultData[0]['food_id'];
$_SESSION['food1_id'] = $resultData[1]['food_id'];

if ($resultData[0]['food_id'] == 0 || $resultData[1]['food_id'] == 0) {
    header('Location: foodNotFound.php');
}

if ($resultData[0]['food_id'] == $resultData[1]['food_id']) {
    header('Location: foodSameResult.php');
}

?>

<?php
$title = "Results";
include("header.php");

?>
<!-- Reference: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_table_basic&stacked=h -->
<div style="padding-left: 5%;padding-right:5%;">
	<div class="container-fluid">
		<h2>Results</h2>
		<div style="padding-top: 30px;" class="table-responsive" align="center">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Item</th>
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

// Get NORMALIZED (to 100g) data for the first food item

$food0amount      = round($resultData[0]['metric_serving_amount']);
$food0calories    = normalizeWeight($resultData[0]['calories'], $resultData[0]);
$food0fat         = normalizeWeight($resultData[0]['fat'], $resultData[0]);
$food0sugar       = normalizeWeight($resultData[0]['sugar'], $resultData[0]);
$food0sodium      = normalizeWeight($resultData[0]['sodium'], $resultData[0]);
$food0protein     = normalizeWeight($resultData[0]['protein'], $resultData[0]);
$food0cholesterol = normalizeWeight($resultData[0]['cholesterol'], $resultData[0]);
$food0carbs       = normalizeWeight($resultData[0]['carbohydrate'], $resultData[0]);
$food1amount      = round($resultData[1]['metric_serving_amount']);
$food1calories    = normalizeWeight($resultData[1]['calories'], $resultData[1]);
$food1fat         = normalizeWeight($resultData[1]['fat'], $resultData[1]);
$food1sugar       = normalizeWeight($resultData[1]['sugar'], $resultData[1]);
$food1sodium      = normalizeWeight($resultData[1]['sodium'], $resultData[1]);
$food1protein     = normalizeWeight($resultData[1]['protein'], $resultData[1]);
$food1cholesterol = normalizeWeight($resultData[1]['cholesterol'], $resultData[1]);
$food1carbs       = normalizeWeight($resultData[1]['carbohydrate'], $resultData[1]);

// TODO: Maybe remove this and store it as a constant somewhere?

$dailycalories    = 2500; // kcal
$dailyfat         = 65; // g
$dailysugar       = 30; // g
$dailysodium      = 2400; // mg
$dailyprotein     = 50; // g
$dailycholesterol = 300; // mg
$dailycarbs       = 300; // g

// scaling preferences, initialized to 1 for normal preference

$caloriesScale = 1;
$sugarScale    = 1;
$sodiumScale   = 1;
$proteinScale  = 1;

if (!isset($_SESSION['user_username'])) { // user is not logged in
    
    // algorithm to determine healthiest choice with 100 g portions
    
    $food0score = -($food0calories / $dailycalories) - ($food0fat / $dailyfat) - ($food0sugar / $dailysugar) - ($food0sodium / $dailysodium) - ($food0cholesterol / $dailycholesterol) + ($food0protein / $dailyprotein) + ($food0carbs / $dailycarbs);
    $food1score = -($food1calories / $dailycalories) - ($food1fat / $dailyfat) - ($food1sugar / $dailysugar) - ($food1sodium / $dailysodium) - ($food1cholesterol / $dailycholesterol) + ($food1protein / $dailyprotein) + ($food1carbs / $dailycarbs);
} else { // user is logged in
    if ($_SESSION['user_calories'] == "High") {
        $caloriesScale = -10;
    }
    
    if ($_SESSION['user_calories'] == "Low") {
        $caloriesScale = 10;
    }
    
    if ($_SESSION['user_sugar'] == "High") {
        $sugarScale = -10;
    }
    
    if ($_SESSION['user_sugar'] == "Low") {
        $sugarScale = 10;
    }
    
    if ($_SESSION['user_sodium'] == "High") {
        $sodiumScale = -10;
    }
    
    if ($_SESSION['user_sodium'] == "Low") {
        $sodiumScale = 10;
    }
    
    if ($_SESSION['user_protein'] == "High") {
        $proteinScale = 10;
    }
    
    if ($_SESSION['user_protein'] == "Low") {
        $proteinScale = -10;
    }
    
    $food0score = -($caloriesScale) * ($food0calories / $dailycalories) - ($food0fat / $dailyfat) - ($sugarScale) * ($food0sugar / $dailysugar) - ($sodiumScale) * ($food0sodium / $dailysodium) - ($food0cholesterol / $dailycholesterol) + ($proteinScale) * ($food0protein / $dailyprotein) + ($food0carbs / $dailycarbs);
    $food1score = -($caloriesScale) * ($food1calories / $dailycalories) - ($food1fat / $dailyfat) - ($sugarScale) * ($food1sugar / $dailysugar) - ($sodiumScale) * ($food1sodium / $dailysodium) - ($food1cholesterol / $dailycholesterol) + ($proteinScale) * ($food1protein / $dailyprotein) + ($food1carbs / $dailycarbs);
}

// variables used to highlight a food item

$highlight0 = "";
$highlight1 = "";

// logic to determine which food to highlight

if ($food0score < $food1score) {
    $highlight1 = "success";
} else if ($food0score > $food1score) {
    $highlight0 = "success";
} else {
    $highlight0 = "warning";
    $highlight1 = "warning";
}

echo '
               <tbody>
                 <tr class=' . $highlight0 . '>
                   <td>' . $resultData[0]['food_name'] . '</td>
                   <td>' . $food0calories . ' kcal</td>
                   <td>' . $food0fat . ' g</td>
                   <td>' . $food0sugar . ' g</td>
                   <td>' . $food0sodium . ' mg</td>
				   <td>' . $food0protein . ' g</td>
				   <td>' . $food0cholesterol . ' mg</td>
				   <td>' . $food0carbs . ' g</td>
                 </tr>
               
                 <tr class=' . $highlight1 . '>
                   <td>' . $resultData[1]['food_name'] . '</td>
                   <td>' . $food1calories . ' kcal</td>
                   <td>' . $food1fat . ' g</td>
                   <td>' . $food1sugar . ' g</td>
                   <td>' . $food1sodium . ' mg</td>
				   <td>' . $food1protein . ' g</td>
				   <td>' . $food1cholesterol . ' mg</td>
				   <td>' . $food1carbs . ' g</td>
                 </tr>
               </tbody>
               ';

// normalizes field to 100 grams

function normalizeWeight($field, $resultData)
{
    $serving_amt_grams = 0;
    if ($resultData['metric_serving_unit'] == "g") {
        $serving_amt_grams = $resultData['metric_serving_amount'];
    } else if ($resultData['metric_serving_unit'] == "oz") {
        $serving_amt_grams = $resultData['metric_serving_amount'] * 28.35;
    }
    
    return round(($field / $serving_amt_grams) * 100);
}

?>
			</table>

		</div>

	</div>
</div>

	<div align="center">
	<?php

// print out the healthier food item

if ($food0score < $food1score) {
    echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
} else if ($food0score > $food1score) {
    echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
} else {
    echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
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
$food0amountA      = round($resultData[0]['metric_serving_amount']);
$food0caloriesA    = round($resultData[0]['calories']);
$food0fatA         = round($resultData[0]['fat']);
$food0sugarA       = round($resultData[0]['sugar']);
$food0sodiumA      = round($resultData[0]['sodium']);
$food0proteinA     = round($resultData[0]['protein']);
$food0cholesterolA = round($resultData[0]['cholesterol']);
$food0carbsA       = round($resultData[0]['carbohydrate']);
$food1amountA      = round($resultData[1]['metric_serving_amount']);
$food1caloriesA    = round($resultData[1]['calories']);
$food1fatA         = round($resultData[1]['fat']);
$food1sugarA       = round($resultData[1]['sugar']);
$food1sodiumA      = round($resultData[1]['sodium']);
$food1proteinA     = round($resultData[1]['protein']);
$food1cholesterolA = round($resultData[1]['cholesterol']);
$food1carbsA       = round($resultData[1]['carbohydrate']);

// algorithm to determine healthiest choice with absolute portions

if (!isset($_SESSION['user_username'])) { // user is not logged in
    
    // algorithm to determine healthiest choice with 100 g portions
    
    $food0scoreA = -($food0caloriesA / $dailycalories) - ($food0fatA / $dailyfat) - ($food0sugarA / $dailysugar) - ($food0sodiumA / $dailysodium) - ($food0cholesterolA / $dailycholesterol) + ($food0proteinA / $dailyprotein) + ($food0carbsA / $dailycarbs);
    $food1scoreA = -($food1caloriesA / $dailycalories) - ($food1fatA / $dailyfat) - ($food1sugarA / $dailysugar) - ($food1sodiumA / $dailysodium) - ($food1cholesterolA / $dailycholesterol) + ($food1proteinA / $dailyprotein) + ($food1carbsA / $dailycarbs);
} else { // user is logged in
    if ($_SESSION['user_calories'] == "High") {
        $caloriesScale = -10;
    }
    
    if ($_SESSION['user_calories'] == "Low") {
        $caloriesScale = 10;
    }
    
    if ($_SESSION['user_sugar'] == "High") {
        $sugarScale = -10;
    }
    
    if ($_SESSION['user_sugar'] == "Low") {
        $sugarScale = 10;
    }
    
    if ($_SESSION['user_sodium'] == "High") {
        $sodiumScale = -10;
    }
    
    if ($_SESSION['user_sodium'] == "Low") {
        $sodiumScale = 10;
    }
    
    if ($_SESSION['user_protein'] == "High") {
        $proteinScale = 10;
    }
    
    if ($_SESSION['user_protein'] == "Low") {
        $proteinScale = -10;
    }
    
    $food0scoreA = -($caloriesScale) * ($food0caloriesA / $dailycalories) - ($food0fatA / $dailyfat) - ($sugarScale) * ($food0sugarA / $dailysugar) - ($sodiumScale) * ($food0sodiumA / $dailysodium) - ($food0cholesterolA / $dailycholesterol) + ($proteinScale) * ($food0proteinA / $dailyprotein) + ($food0carbsA / $dailycarbs);
    $food1scoreA = -($caloriesScale) * ($food1caloriesA / $dailycalories) - ($food1fatA / $dailyfat) - ($sugarScale) * ($food1sugarA / $dailysugar) - ($sodiumScale) * ($food1sodiumA / $dailysodium) - ($food1cholesterolA / $dailycholesterol) + ($proteinScale) * ($food1proteinA / $dailyprotein) + ($food1carbsA / $dailycarbs);
}

echo '
               <tbody>
                 <tr class=' . $highlight0 . '>
                   <td>' . $resultData[0]['food_name'] . '</td>
				   <td>' . $food0amountA . $resultData[0]['metric_serving_unit'] . ' </td>
                   <td>' . $food0caloriesA . ' kcal</td>
                   <td>' . $food0fatA . ' g</td>
                   <td>' . $food0sugarA . ' g</td>
                   <td>' . $food0sodiumA . ' mg</td>
				   <td>' . $food0proteinA . ' g</td>
				   <td>' . $food0cholesterolA . ' mg</td>
				   <td>' . $food0carbsA . ' g</td>
                 </tr>
               
                 <tr class=' . $highlight1 . '>
                   <td>' . $resultData[1]['food_name'] . '</td>
				   <td>' . $food1amountA . $resultData[0]['metric_serving_unit'] . ' </td>
                   <td>' . $food1caloriesA . ' kcal</td>
                   <td>' . $food1fatA . ' g</td>
                   <td>' . $food1sugarA . ' g</td>
                   <td>' . $food1sodiumA . ' mg</td>
				   <td>' . $food1proteinA . ' g</td>
				   <td>' . $food1cholesterolA . ' mg</td>
				   <td>' . $food1carbsA . ' g</td>
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

if ($food0scoreA < $food1scoreA) {
    echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
} else if ($food0scoreA > $food1scoreA) {
    echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
} else {
    echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
}

?>
		<a href="index.php" type="submit" class="btn btn-primary">Change Food Items</a>
	</div>
	<?php
include "footer.php";
?>
