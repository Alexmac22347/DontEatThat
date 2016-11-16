<?php
require_once('php/FoodFinder.php');
$config = include('../config/config.php');

session_start();

$foodFinder    = new FoodFinder($config['consumer_key'], $config['secret_key']);
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

// Get NORMALIZED (to 100g) data for the first food item

// food 0 statistics
$food0amount      = round($resultData[0]['metric_serving_amount']);
$food0calories    = normalizeWeight($resultData[0]['calories'], $resultData[0]); // bad
$food0carbs       = normalizeWeight($resultData[0]['carbohydrate'], $resultData[0]); // good
$food0protein     = normalizeWeight($resultData[0]['protein'], $resultData[0]); // good
$food0fat         = normalizeWeight($resultData[0]['fat'], $resultData[0]); // bad
$food0cholesterol = normalizeWeight($resultData[0]['cholesterol'], $resultData[0]); // bad
$food0sodium      = normalizeWeight($resultData[0]['sodium'], $resultData[0]); // bad
$food0potassium   = normalizeWeight($resultData[0]['potassium'], $resultData[0]); // good
$food0fiber       = normalizeWeight($resultData[0]['fiber'], $resultData[0]); // good
$food0sugar       = normalizeWeight($resultData[0]['sugar'], $resultData[0]); // bad
$food0vitA        = normalizeWeight($resultData[0]['vitamin_a'], $resultData[0]); // good
$food0vitC        = normalizeWeight($resultData[0]['vitamin_c'], $resultData[0]); // good
$food0calcium     = normalizeWeight($resultData[0]['calcium'], $resultData[0]); // good
$food0iron        = normalizeWeight($resultData[0]['iron'], $resultData[0]); // good

// food 1 statistics
$food1amount      = round($resultData[1]['metric_serving_amount']);
$food1calories    = normalizeWeight($resultData[1]['calories'], $resultData[1]); // bad
$food1carbs       = normalizeWeight($resultData[1]['carbohydrate'], $resultData[1]); // good
$food1protein     = normalizeWeight($resultData[1]['protein'], $resultData[1]); // good
$food1fat         = normalizeWeight($resultData[1]['fat'], $resultData[1]); // bad
$food1cholesterol = normalizeWeight($resultData[1]['cholesterol'], $resultData[1]); // bad
$food1sodium      = normalizeWeight($resultData[1]['sodium'], $resultData[1]); // bad
$food1potassium   = normalizeWeight($resultData[1]['potassium'], $resultData[1]); // good
$food1fiber       = normalizeWeight($resultData[1]['fiber'], $resultData[1]); // good
$food1sugar       = normalizeWeight($resultData[1]['sugar'], $resultData[1]); // bad
$food1vitA        = normalizeWeight($resultData[1]['vitamin_a'], $resultData[1]); // good
$food1vitC        = normalizeWeight($resultData[1]['vitamin_c'], $resultData[1]); // good
$food1calcium     = normalizeWeight($resultData[1]['calcium'], $resultData[1]); // good
$food1iron        = normalizeWeight($resultData[1]['iron'], $resultData[1]); // good

// TODO: Maybe remove this and store it as a constant somewhere?

$dailycalories    = 2500; // kcal
$dailycarbs       = 300; // g
$dailyprotein     = 50; // g
$dailyfat         = 65; // g
$dailycholesterol = 300; // mg
$dailysodium      = 2400; // mg
$dailypotassium   = 5000; // mg
$dailyfiber       = 30; // g 
$dailysugar       = 30; // g
$dailyvitA        = 100; // percentage
$dailyvitC        = 100; // percentage
$dailycalcium     = 100; // percentage
$dailyiron        = 100; // percentage

// scaling preferences, initialized to 1 for normal preference

$caloriesScale = 1;
$sugarScale    = 1;
$sodiumScale   = 1;
$proteinScale  = 1;
$calciumScale  = 1;

if (!isset($_SESSION['user_username'])) { // user is not logged in
    
    // algorithm to determine healthiest choice with 100 g portions
    $food0score = -($food0calories / $dailycalories) + ($food0carbs / $dailycarbs) + ($food0protein / $dailyprotein) - ($food0fat / $dailyfat) - ($food0cholesterol / $dailycholesterol) - ($food0sodium / $dailysodium) + ($food0potassium / $dailypotassium) + ($food0fiber / $dailyfiber) - ($food0sugar / $dailysugar) + ($food0vitA / $dailyvitA) + ($food0vitC / $dailyvitC) + ($food0calcium / $dailycalcium) + ($food0iron / $dailyiron);
    
    $food1score = -($food1calories / $dailycalories) + ($food1carbs / $dailycarbs) + ($food1protein / $dailyprotein) - ($food1fat / $dailyfat) - ($food1cholesterol / $dailycholesterol) - ($food1sodium / $dailysodium) + ($food1potassium / $dailypotassium) + ($food1fiber / $dailyfiber) - ($food1sugar / $dailysugar) + ($food1vitA / $dailyvitA) + ($food1vitC / $dailyvitC) + ($food1calcium / $dailycalcium) + ($food1iron / $dailyiron);
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
    
    if ($_SESSION['user_calcium'] == "High") {
        $calciumScale = 10;
    }
    
    if ($_SESSION['user_calcium'] == "Low") {
        $calciumScale = -10;
    }
    
    $food0score = -($caloriesScale) * ($food0calories / $dailycalories) + ($food0carbs / $dailycarbs) + ($proteinScale) * ($food0protein / $dailyprotein) - ($food0fat / $dailyfat) - ($food0cholesterol / $dailycholesterol) - ($sodiumScale) * ($food0sodium / $dailysodium) + ($food0potassium / $dailypotassium) + ($food0fiber / $dailyfiber) - ($sugarScale) * ($food0sugar / $dailysugar) + ($food0vitA / $dailyvitA) + ($food0vitC / $dailyvitC) + ($calciumScale) * ($food0calcium / $dailycalcium) + ($food0iron / $dailyiron);
    
    $food1score = -($caloriesScale) * ($food1calories / $dailycalories) + ($food1carbs / $dailycarbs) + ($proteinScale) * ($food1protein / $dailyprotein) - ($food1fat / $dailyfat) - ($food1cholesterol / $dailycholesterol) - ($sodiumScale) * ($food1sodium / $dailysodium) + ($food1potassium / $dailypotassium) + ($food1fiber / $dailyfiber) - ($sugarScale) * ($food1sugar / $dailysugar) + ($food1vitA / $dailyvitA) + ($food1vitC / $dailyvitC) + ($calciumScale) * ($food1calcium / $dailycalcium) + ($food1iron / $dailyiron);
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
if (!isset($_SESSION['user_username'])) {
    if ($food0score < $food1score) {
        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
    } else if ($food0score > $food1score) {
        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    }
} else { // user logged in
    if ($food0score < $food1score) {
        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
    } else if ($food0score > $food1score) {
        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    } else {
        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '100 g ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
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
// food 0 statistics
$food0amountA      = round($resultData[0]['metric_serving_amount']);
$food0caloriesA    = round($resultData[0]['calories']); // bad
$food0carbsA       = round($resultData[0]['carbohydrate']); // good
$food0proteinA     = round($resultData[0]['protein']); // good
$food0fatA         = round($resultData[0]['fat']); // bad
$food0cholesterolA = round($resultData[0]['cholesterol']); // bad
$food0sodiumA      = round($resultData[0]['sodium']); // bad
$food0potassiumA   = round($resultData[0]['potassium']); // good
$food0fiberA       = round($resultData[0]['fiber']); // good
$food0sugarA       = round($resultData[0]['sugar']); // bad
$food0vitAA        = round($resultData[0]['vitamin_a']); // good
$food0vitCA        = round($resultData[0]['vitamin_c']); // good
$food0calciumA     = round($resultData[0]['calcium']); // good
$food0ironA        = round($resultData[0]['iron']); // good

// food 1 statistics
$food1amountA      = round($resultData[1]['metric_serving_amount']);
$food1caloriesA    = round($resultData[1]['calories']); // bad
$food1carbsA       = round($resultData[1]['carbohydrate']); // good
$food1proteinA     = round($resultData[1]['protein']); // good
$food1fatA         = round($resultData[1]['fat']); // bad
$food1cholesterolA = round($resultData[1]['cholesterol']); // bad
$food1sodiumA      = round($resultData[1]['sodium']); // bad
$food1potassiumA   = round($resultData[1]['potassium']); // good
$food1fiberA       = round($resultData[1]['fiber']); // good
$food1sugarA       = round($resultData[1]['sugar']); // bad
$food1vitAA        = round($resultData[1]['vitamin_a']); // good
$food1vitCA        = round($resultData[1]['vitamin_c']); // good
$food1calciumA     = round($resultData[1]['calcium']); // good
$food1ironA        = round($resultData[1]['iron']); // good

// algorithm to determine healthiest choice with absolute portions

if (!isset($_SESSION['user_username'])) { // user is not logged in
    
    // algorithm to determine healthiest choice with provided portions
    $food0scoreA = -($food0caloriesA / $dailycalories) + ($food0carbsA / $dailycarbs) + ($food0proteinA / $dailyprotein) - ($food0fatA / $dailyfat) - ($food0cholesterolA / $dailycholesterol) - ($food0sodiumA / $dailysodium) + ($food0potassiumA / $dailypotassium) + ($food0fiberA / $dailyfiber) - ($food0sugarA / $dailysugar) + ($food0vitAA / $dailyvitA) + ($food0vitCA / $dailyvitC) + ($food0calciumA / $dailycalcium) + ($food0ironA / $dailyiron);
    
    $food1scoreA = -($food1caloriesA / $dailycalories) + ($food1carbsA / $dailycarbs) + ($food1proteinA / $dailyprotein) - ($food1fatA / $dailyfat) - ($food1cholesterolA / $dailycholesterol) - ($food1sodiumA / $dailysodium) + ($food1potassiumA / $dailypotassium) + ($food1fiberA / $dailyfiber) - ($food1sugarA / $dailysugar) + ($food1vitAA / $dailyvitA) + ($food1vitCA / $dailyvitC) + ($food1calciumA / $dailycalcium) + ($food1ironA / $dailyiron);
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
    $food0scoreA = -($caloriesScale) * ($food0caloriesA / $dailycalories) + ($food0carbsA / $dailycarbs) + ($proteinScale) * ($food0proteinA / $dailyprotein) - ($food0fatA / $dailyfat) - ($food0cholesterolA / $dailycholesterol) - ($sodiumScale) * ($food0sodiumA / $dailysodium) + ($food0potassiumA / $dailypotassium) + ($food0fiberA / $dailyfiber) - ($sugarScale) * ($food0sugarA / $dailysugar) + ($food0vitAA / $dailyvitA) + ($food0vitCA / $dailyvitC) + ($food0calciumA / $dailycalcium) + ($food0ironA / $dailyiron);
    if ($_SESSION['user_calcium'] == "High") {
        $calciumScale = 10;
    }
    
    if ($_SESSION['user_calcium'] == "Low") {
        $calciumScale = -10;
    }
    $food0scoreA = -($caloriesScale) * ($food0caloriesA / $dailycalories) + ($food0carbsA / $dailycarbs) + ($proteinScale) * ($food0proteinA / $dailyprotein) - ($food0fatA / $dailyfat) - ($food0cholesterolA / $dailycholesterol) - ($sodiumScale) * ($food0sodiumA / $dailysodium) + ($food0potassiumA / $dailypotassium) + ($food0fiberA / $dailyfiber) - ($sugarScale) * ($food0sugarA / $dailysugar) + ($food0vitAA / $dailyvitA) + ($food0vitCA / $dailyvitC) + ($calciumScale) * ($food0calciumA / $dailycalcium) + ($food0ironA / $dailyiron);
    
    $food1scoreA = -($caloriesScale) * ($food1caloriesA / $dailycalories) + ($food1carbsA / $dailycarbs) + ($proteinScale) * ($food1proteinA / $dailyprotein) - ($food1fatA / $dailyfat) - ($food1cholesterolA / $dailycholesterol) - ($sodiumScale) * ($food1sodiumA / $dailysodium) + ($food1potassiumA / $dailypotassium) + ($food1fiberA / $dailyfiber) - ($sugarScale) * ($food1sugarA / $dailysugar) + ($food1vitAA / $dailyvitA) + ($food1vitCA / $dailyvitC) + ($calciumScale) * ($food1calciumA / $dailycalcium) + ($food1ironA / $dailyiron);
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
if (!isset($_SESSION['user_username'])) {
    if ($food0scoreA < $food1scoreA) {
        echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
    } else if ($food0scoreA > $food1scoreA) {
        echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    } else {
        echo '<p>' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    }
} else { // user is logged in
    if ($food0scoreA < $food1scoreA) {
        echo '<p>' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . '</p>';
    } else if ($food0scoreA > $food1scoreA) {
        echo '<p>' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    } else {
        echo '<p>' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[0]['food_name'] . ' is about the same as ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $resultData[1]['food_name'] . '</p>';
    }
}

?>
		<a href="index.php" type="submit" class="btn btn-primary">Change Food Items</a>
	</div>
	<?php
include "footer.php";
?>
