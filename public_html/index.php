<?php 
    $title = "Home";
    include("layout/header.php"); 
    ?>
<!-- Beginning of logo, input fields and buttons -->
<div align="center" style="padding-top: 5%;">
    <div class="container-fluid">
        <img class="img-responsive title-style" src="res/logo.jpg">          
        <h2 style="font-size: 3vw;">Please Enter Food Items</h2>
        <form class="form-inline" action="results.php">
            <div>
                <div class="form-group food1">
                    <input class="form-control" type="text" id="item1" name="item1"
                        placeholder="Enter food item 1" size="40">
                </div>
                <div class="form-group food2">
                    <input class="form-control" type="text" id="item2" name="item2"
                        placeholder="Enter food item 2" size="40">
                </div>
            </div>
            <p id="foodFormError0" class="form-error">Please enter two food items</p>
            <p id="foodFormError1" class="form-error">Please enter two different food items</p>
            <div>
                <button id="food-submit" type="submit" class="btn btn-primary compare-button">Compare</button>
            </div>
            <div>
                <button type="reset" class="btn btn-danger clear-button">Clear Choices</button>
            </div>
        </form>
    </div>
</div>
<!-- End of logo, input fields and buttons -->
<?php include "layout/footer.php" ?>
