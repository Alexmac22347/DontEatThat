<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <body>
        <div style="padding-top: 30px;" class="table-responsive" align=
            "center">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Serving Size</th>
                        <th>Calories</th>
                        <th>Fat</th>
                        <th>Sugar</th>
                        <th>Sodium</th>
                        <th>Cholesterol</th>
                        <th>Carbohydrates</th>
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
                    ), false);
                    
                    
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
                    
                    echo '
                         <tbody>
                           <tr class=' . $highlight0 . '>
                             <td>' . $resultData[0]['food_name'] . '</td>
                             <td>' . round($resultData[0]['metric_serving_amount']) . ' g </td>
                             <td>' . round($resultData[0]['calories']) . ' cal</td>
                             <td>' . round($resultData[0]['fat']) . ' g</td>
                             <td>' . round($resultData[0]['sugar']) . ' g</td>
                             <td>' . round($resultData[0]['sodium']) . ' mg</td>
                             <td>' . round($resultData[0]['cholesterol']) . ' mg</td>
                             <td>' . round($resultData[0]['carbohydrate']) . ' g</td>
                             <td>' . round($resultData[0]['potassium']) . ' mg</td>
                             <td>' . round($resultData[0]['fiber']) . ' g</td>
                             <td>' . round($resultData[0]['vitamin_a']) . ' %</td>
                             <td>' . round($resultData[0]['vitamin_c']) . ' %</td>
                             <td>' . round($resultData[0]['calcium']) . ' %</td>
                             <td>' . round($resultData[0]['iron']) . ' %</td>
                             <td>' . round($resultData[0]['protein']) . ' g</td>
                           </tr>
                         
                           <tr class=' . $highlight1 . '>
                             <td>' . $resultData[1]['food_name'] . '</td>
                             <td>' . round($resultData[1]['metric_serving_amount']) . ' g </td>
                             <td>' . round($resultData[1]['calories']) . ' cal</td>
                             <td>' . round($resultData[1]['fat']) . ' g</td>
                             <td>' . round($resultData[1]['sugar']) . ' g</td>
                             <td>' . round($resultData[1]['sodium']) . ' mg</td>
                             <td>' . round($resultData[1]['cholesterol']) . ' mg</td>
                             <td>' . round($resultData[1]['carbohydrate']) . ' g</td>
                             <td>' . round($resultData[1]['potassium']) . ' mg</td>
                             <td>' . round($resultData[1]['fiber']) . ' g</td>
                             <td>' . round($resultData[1]['vitamin_a']) . ' %</td>
                             <td>' . round($resultData[1]['vitamin_c']) . ' %</td>
                             <td>' . round($resultData[1]['calcium']) . ' %</td>
                             <td>' . round($resultData[1]['iron']) . ' %</td>
                             <td>' . round($resultData[1]['protein']) . ' g</td>
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
                        echo '<p style="text-align: center;">' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' about as healthy as ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
                        echo '<p style="text-align: center;">' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else {
                        echo '<p style="text-align: center;">' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
                    }
                } else { // user logged in
                    if (abs($scoredFoods[0]['score'] - $scoredFoods[1]['score']) < MINDIFFERENCE) {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' about as healthy as ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else if ($scoredFoods[0]['score'] > $scoredFoods[1]['score']) {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . '</p>';
                    } else {
                        echo '<p style="text-align: center;">' . 'Based on your preferences, ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[1]['food_name'] . ' is healthier than ' . '<b>' . '1 serving ' . '</b>' . 'of ' . $scoredFoods[0]['food_name'] . '</p>';
                    }
                }                
            ?>
        </div>
    </body>
</html>
