<?php
$title = "Results";
include("layout/header.php");
include('php/runQueries.php');
?>

<!-- Reference: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_table_basic&stacked=h -->
<div style="padding-left: 5%;padding-right:5%;">
	<div class="container-fluid">
		<h2>Results</h2>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#100g">Per 100 grams</a></li>
            <li><a data-toggle="tab" href="#serving">Per Serving Size</a></li>
        </ul>

        <div class="tab-content">
            <div id="100g" class="tab-pane fade in active">
                <div w3-include-html="results-100g.php"></div>
                <script> w3IncludeHTML(); </script>
            </div>
            <div id="serving" class="tab-pane fade">
                <div w3-include-html="results-serving.php"></div>
                <script> w3IncludeHTML(); </script>
            </div>
        </div>
    </div>
<br><br>
<div align="center">
    <a href="index.php" type="submit" class="btn btn-primary">Change Food Items</a>
</div>

<?php
include "layout/footer.php";
?>
