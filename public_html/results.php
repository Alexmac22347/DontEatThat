<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Results &#8226; Don't Eat That!</title>
      <meta name="generator" content="HTML Tidy for Linux (vers 25 March 2009), see www.w3.org">
      <meta charset="utf-8">
      <!-- Ensure proper rendering on mobile -->
      <meta name="viewport" content="width=device-width, intial-scale=1">
      <!-- Bootstrap -->
      <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <!-- Link to an external style sheet -->
      <link rel="stylesheet" type="text/css" href="mainstyle.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
      <!-- Latest compiled JavaScript -->
      <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- Custom jquery functions -->
      <script src="jquery/jQueryFunctions.js" type="text/javascript"></script>
      <script src="foodquery.php"></script>
   </head>
   <body>
      <div id="header"></div>
      <!-- Reference: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_table_basic&stacked=h -->
      <div style="padding-left: 5%;padding-right:5%;">
         <div class="container-fluid">
            <h2>Results</h2>
            <div align="center" style="padding-top: 2%;">
               <table class="table">
                  <thead>
                     <tr>
                        <th>Item</th>
                        <th>Serving Size</th>
                        <th>Calories</th>
                        <th>Fat</th>
                        <th>Sugar</th>
                        <th>Sodium</th>
                     </tr>
                  </thead>
                  <?php
                     $resultData = include('foodquery.php');
					 $metric_serving_amount0 = $resultData[0]['metric_serving_amount'];
					 $metric_serving_amount1 = $resultData[1]['metric_serving_amount'];
                     echo '
                     <tbody>
                       <tr>
                         <td class="col-md-2">' . $resultData[0]['food_name'] . '</td>
                     
                         <td class="col-md-2">' . 100 . " " . $resultData[0]['metric_serving_unit'] . '</td>
                     
                         <td class="col-md-2">' . round(($resultData[0]['calories']/$metric_serving_amount0)*100) . ' kcal</td>
                     
                         <td class="col-md-2">' . round(($resultData[0]['fat']/$metric_serving_amount0)*100)  . ' g</td>
                     
                         <td class="col-md-2">' . round(($resultData[0]['sugar']/$metric_serving_amount0)*100)   . ' g</td>
                     
                         <td>' . round(($resultData[0]['sodium']/$metric_serving_amount0)*100) . ' mg</td>
                       </tr>
                     </tbody>
                     
                     <tbody>
                       <tr>
                         <td class="col-md-2">' . $resultData[1]['food_name'] . '</td>
                     
                         <td class="col-md-2">' . 100 . " " . $resultData[1]['metric_serving_unit'] . '</td>
                     
                         <td class="col-md-2">' . round(($resultData[1]['calories']/$metric_serving_amount1)*100) . ' kcal</td>
                     
                         <td class="col-md-2">' . round(($resultData[1]['fat']/$metric_serving_amount1)*100) . ' g</td>
                     
                         <td class="col-md-2">' . round(($resultData[1]['sugar']/$metric_serving_amount1)*100)  . ' g</td>
                     
                         <td>' . round(($resultData[1]['sodium']/$metric_serving_amount1)*100) . ' mg</td>
                       </tr>
                     </tbody>
                     '
                     ?>
               </table>
            </div>
         </div>
      </div>
      <div align="center" style="padding-top: 2%;">
         <a href="index.html" type="submit" class="btn btn-primary compare-button">Change Food Items</a>
      </div>
      <div id="footer"></div>
   </body>
</html>
