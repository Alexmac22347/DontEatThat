<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <body>
        <div style="padding-top: 30px;" class="table-responsive" align=
            "center">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item (100 g portions)</th>
                        <th>Calories</th>
                        <th>Fat</th>
                        <th>Sugar</th>
                        <th>Sodium</th>
                        <th>Cholesterol</th>
                        <th>Potassium</th>
                        <th>Fiber</th>
                        <th>Vitamin A</th>
                        <th>Vitamin C</th>
                        <th>Calcium</th>
                        <th>Iron</th>
                        <th>Protein</th>
                    </tr>
                </thead>
                <?php
                    if(session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    require_once('classes/FoodComparer.php');
                    
                    if (!isset($_SESSION['user_username'])) {
                        $foodComparer = new vendor\project\FoodComparer("Normal", "Normal", "Normal", "Normal", "Normal");
                    } else {
                        $foodComparer = new vendor\project\FoodComparer($_SESSION['user_calories'], $_SESSION['user_sugar'], $_SESSION['user_sodium'], $_SESSION['user_protein'], $_SESSION['user_calcium']);
                    }
                    
                    $resultData[0] = $_SESSION['foodData0'];
                    $resultData[1] = $_SESSION['foodData1'];
                    
                    $scoredFoods = $foodComparer->getScores(array(
                        $_SESSION['foodData0'],
                        $_SESSION['foodData1']
                    ), true);
                    
                    
                    // logic to determine which food to highlight
                    $highlight0 = "";
                    $highlight1 = "";
                    if (abs($scoredFoods[0]['score'] - $scoredFoods[1]['score']) < MINDIFFERENCE) {
                        $highlight0 = "";
                        $highlight1 = "";
                    } else if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
                        $highlight0 = "success";
                    } else {
                        $highlight1 = "success";
                    }
                    
                    $normalizedCaloriesFood0     = $foodComparer->normalizeWeight($resultData[0]['calories'], $resultData[0]['metric_serving_amount']);
                    $normalizedFatFood0          = $foodComparer->normalizeWeight($resultData[0]['fat'], $resultData[0]['metric_serving_amount']);
                    $normalizedSugarFood0        = $foodComparer->normalizeWeight($resultData[0]['sugar'], $resultData[0]['metric_serving_amount']);
                    $normalizedSodiumFood0       = $foodComparer->normalizeWeight($resultData[0]['sodium'], $resultData[0]['metric_serving_amount']);
                    $normalizedProteinFood0      = $foodComparer->normalizeWeight($resultData[0]['protein'], $resultData[0]['metric_serving_amount']);
                    $normalizedCholestrolFood0   = $foodComparer->normalizeWeight($resultData[0]['cholesterol'], $resultData[0]['metric_serving_amount']);
                    $normalizedCarbohydrateFood0 = $foodComparer->normalizeWeight($resultData[0]['carbohydrate'], $resultData[0]['metric_serving_amount']);
                    $normalizedCalciumFood0      = $foodComparer->normalizeWeight($resultData[0]['calcium'], $resultData[0]['metric_serving_amount']);
                    
                    $normalizedPotassiumFood0    = $foodComparer->normalizeWeight($resultData[0]['potassium'], $resultData[0]['metric_serving_amount']);
                    $normalizedFiberFood0        = $foodComparer->normalizeWeight($resultData[0]['fiber'], $resultData[0]['metric_serving_amount']);
                    $normalizedVitaminAFood0     = $foodComparer->normalizeWeight($resultData[0]['vitamin_a'], $resultData[0]['metric_serving_amount']);
                    $normalizedVitaminCFood0     = $foodComparer->normalizeWeight($resultData[0]['vitamin_c'], $resultData[0]['metric_serving_amount']);
                    $normalizedIronFood0         = $foodComparer->normalizeWeight($resultData[0]['iron'], $resultData[0]['metric_serving_amount']);
                    $normalizedProteinFood0      = $foodComparer->normalizeWeight($resultData[0]['protein'], $resultData[0]['metric_serving_amount']);
                    
                    $normalizedCaloriesFood1     = $foodComparer->normalizeWeight($resultData[1]['calories'], $resultData[1]['metric_serving_amount']);
                    $normalizedFatFood1          = $foodComparer->normalizeWeight($resultData[1]['fat'], $resultData[1]['metric_serving_amount']);
                    $normalizedSugarFood1        = $foodComparer->normalizeWeight($resultData[1]['sugar'], $resultData[1]['metric_serving_amount']);
                    $normalizedSodiumFood1       = $foodComparer->normalizeWeight($resultData[1]['sodium'], $resultData[1]['metric_serving_amount']);
                    $normalizedProteinFood1      = $foodComparer->normalizeWeight($resultData[1]['protein'], $resultData[1]['metric_serving_amount']);
                    $normalizedCholestrolFood1   = $foodComparer->normalizeWeight($resultData[1]['cholesterol'], $resultData[1]['metric_serving_amount']);
                    $normalizedCarbohydrateFood1 = $foodComparer->normalizeWeight($resultData[1]['carbohydrate'], $resultData[1]['metric_serving_amount']);
                    $normalizedCalciumFood1      = $foodComparer->normalizeWeight($resultData[1]['calcium'], $resultData[1]['metric_serving_amount']);
                    
                    $normalizedPotassiumFood1    = $foodComparer->normalizeWeight($resultData[1]['potassium'], $resultData[1]['metric_serving_amount']);
                    $normalizedFiberFood1        = $foodComparer->normalizeWeight($resultData[1]['fiber'], $resultData[1]['metric_serving_amount']);
                    $normalizedVitaminAFood1     = $foodComparer->normalizeWeight($resultData[1]['vitamin_a'], $resultData[1]['metric_serving_amount']);
                    $normalizedVitaminCFood1     = $foodComparer->normalizeWeight($resultData[1]['vitamin_c'], $resultData[1]['metric_serving_amount']);
                    $normalizedIronFood1         = $foodComparer->normalizeWeight($resultData[1]['iron'], $resultData[1]['metric_serving_amount']);
                    $normalizedProteinFood1      = $foodComparer->normalizeWeight($resultData[1]['protein'], $resultData[1]['metric_serving_amount']);
                    
                    echo '
                         <tbody>
                           <tr class=' . $highlight0 . '>
                             <td>' . $resultData[0]['food_name'] . '</td>
                             <td>' . round($normalizedCaloriesFood0) . ' cal</td>
                             <td>' . round($normalizedFatFood0) . ' g</td>
                             <td>' . round($normalizedSugarFood0) . ' g</td>
                             <td>' . round($normalizedSodiumFood0) . ' mg</td>
                             <td>' . round($normalizedCholestrolFood0) . ' mg</td>
                             <td>' . round($normalizedPotassiumFood0) . ' mg</td>
                             <td>' . round($normalizedFiberFood0) . ' g</td>
                             <td>' . round($normalizedVitaminAFood0) . ' %</td>
                             <td>' . round($normalizedVitaminCFood0) . ' %</td>
                             <td>' . round($normalizedCalciumFood0) . ' %</td>
                             <td>' . round($normalizedIronFood0) . ' %</td>
                             <td>' . round($normalizedProteinFood0) . ' g</td>
                           </tr>
                         
                           <tr class=' . $highlight1 . '>
                             <td>' . $resultData[1]['food_name'] . '</td>
                             <td>' . round($normalizedCaloriesFood1) . ' cal</td>
                             <td>' . round($normalizedFatFood1) . ' g</td>
                             <td>' . round($normalizedSugarFood1) . ' g</td>
                             <td>' . round($normalizedSodiumFood1) . ' mg</td>
                             <td>' . round($normalizedCholestrolFood1) . ' mg</td>
                             <td>' . round($normalizedPotassiumFood1) . ' mg</td>
                             <td>' . round($normalizedFiberFood1) . ' g</td>
                             <td>' . round($normalizedVitaminAFood1) . ' %</td>
                             <td>' . round($normalizedVitaminCFood1) . ' %</td>
                             <td>' . round($normalizedCalciumFood1) . ' %</td>
                             <td>' . round($normalizedIronFood1) . ' %</td>
                             <td>' . round($normalizedProteinFood1) . ' g</td>
                           </tr>
                         </tbody>
                         ';
                    
                    ?>
            </table>
        </div>
        <div align="center">
            <?php
                // print out the healthier food item
                if (!isset($_SESSION['user_username'])) {
                    if (abs($scoredFoods[0]['score'] - $scoredFoods[1]['score']) < MINDIFFERENCE) {
                        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' about as healthy as ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
                        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else {
                        echo '<p style="text-align: center;">' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
                    }
                } else { // user logged in
                    if (abs($scoredFoods[0]['score'] - $scoredFoods[1]['score']) < MINDIFFERENCE) {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' about as healthy as ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '100 g ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
                    }
                }
                
            ?>
        </div>
    </body>
</html>
