<?php 
    $title = "Manage Account";
    include("layout/header.php");
    
    // Determine user's current settings and selects
    // CALORIES
    if ($_SESSION['user_calories'] == "High") {
    $CalSelHigh = "selected";
    $CalSelLow = "";
    $CalSelNormal = "";
    } else if ($_SESSION['user_calories'] == "Low") {
    $CalSelHigh = "";
    $CalSelLow = "selected";
    $CalSelNormal = "";
    } else if ($_SESSION['user_calories'] == "Normal") {
    $CalSelHigh = "";
    $CalSelLow = "";
    $CalSelNormal = "selected";
    }
    
    // SUGAR
    if ($_SESSION['user_sugar'] == "High") {
    $SugSelHigh = "selected";
    $SugSelLow = "";
    $SugSelNormal = "";
    } else if ($_SESSION['user_sugar'] == "Low") {
    $SugSelHigh = "";
    $SugSelLow = "selected";
    $SugSelNormal = "";
    } else if ($_SESSION['user_sugar'] == "Normal") {
    $SugSelHigh = "";
    $SugSelLow = "";
    $SugSelNormal = "selected";
    }
    
    // SODIUM
    if ($_SESSION['user_sodium'] == "High") {
    $SodSelHigh = "selected";
    $SodSelLow = "";
    $SodSelNormal = "";
    } else if ($_SESSION['user_sodium'] == "Low") {
    $SodSelHigh = "";
    $SodSelLow = "selected";
    $SodSelNormal = "";
    } else if ($_SESSION['user_sodium'] == "Normal") {
    $SodSelHigh = "";
    $SodSelLow = "";
    $SodSelNormal = "selected";
    }
    
    // PROTEIN
    if ($_SESSION['user_protein'] == "High") {
    $ProSelHigh = "selected";
    $ProSelLow = "";
    $ProSelNormal = "";
    } else if ($_SESSION['user_protein'] == "Low") {
    $ProSelHigh = "";
    $ProSelLow = "selected";
    $ProSelNormal = "";
    } else if ($_SESSION['user_protein'] == "Normal") {
    $ProSelHigh = "";
    $ProSelLow = "";
    $ProSelNormal = "selected";
    }
    
    // CALCIUM
    if ($_SESSION['user_calcium'] == "High") {
    $CalSelHigh = "selected";
    $CalSelLow = "";
    $CalSelNormal = "";
    } else if ($_SESSION['user_calcium'] == "Low") {
    $CalSelHigh = "";
    $CalSelLow = "selected";
    $CalSelNormal = "";
    } else if ($_SESSION['user_calcium'] == "Normal") {
    $CalSelHigh = "";
    $CalSelLow = "";
    $CalSelNormal = "selected";
    }
    
    // Server-Side Error Handling on Submit
    $url                  = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // used in determining if we need to display errors
    // Initialize to state with no errors
    $errorInvalidPassword = false;
    // Determine if we need to display errors
    if (strpos($url, 'errorPassword=invalid') !== false) {
    $errorInvalidPassword = true;
    }
    ?>
<div>
    <div class="container-fluid">
        <form class="form-horizontal" action="php/accountUpdate.php" method="post">
            <h2 style="padding-left: 0;">Manage Account</h2>
            <div style="padding-top: 40px; padding-left: 15px; padding-right: 15px" class="form-group">
                <!-- FIRST NAME -->
                <div class="form-group" >
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" value="<?php echo $_SESSION['user_name']; ?> "  name="update-name" disabled>
                    </div>
                </div>
                <!-- USERNAME -->
                <div class="form-group" >
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" value="<?php echo $_SESSION['user_username']; ?> " name="update-username" disabled>
                    </div>
                </div>
                <!-- PASSWORD -->
                <div class="form-group" >
                    <label class="col-sm-2 control-label">New Password</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="password" placeholder="Enter Password" name="update-password">
                        <?php
                            // SERVER-SIDE VALIDATION FOR PASSWORD
                            if ($errorInvalidPassword !== false) {
                                echo "<label class='error'>Password must be at least 6 characters long and contain only alphanumeric characters.</label>";
                            }
                            ?>
                    </div>
                </div>
                <!-- Meal Preference(s) -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Meal Preference</label>
                    <div>
                        <div class="col-sm-2">
                            <label class="col-sm-2">Calories</label>
                            <select class="form-control" name="update-calories">
                                <option value = "Normal" <?php echo $CalSelNormal; ?> >Normal</option>
                                <option value = "High" <?php echo $CalSelHigh; ?> >High</option>
                                <option value = "Low" <?php echo $CalSelLow; ?> >Low</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-2">Sugar</label>
                            <select class="form-control" name="update-sugar">
                                <option value = "Normal" <?php echo $SugSelNormal; ?> >Normal</option>
                                <option value = "High" <?php echo $SugSelHigh; ?> >High</option>
                                <option value = "Low" <?php echo $SugSelLow; ?> >Low</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-2">Sodium</label>
                            <select class="form-control" name="update-sodium">
                                <option value = "Normal" <?php echo $SodSelNormal; ?> >Normal</option>
                                <option value = "High" <?php echo $SodSelHigh; ?> >High</option>
                                <option value = "Low" <?php echo $SodSelLow; ?> >Low</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-2">Protein</label>
                            <select class="form-control" name="update-protein">
                                <option value = "Normal" <?php echo $ProSelNormal; ?> >Normal</option>
                                <option value = "High" <?php echo $ProSelHigh; ?> >High</option>
                                <option value = "Low" <?php echo $ProSelLow; ?> >Low</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-2">Calcium</label>
                            <select class="form-control" name="update-calcium">
                                <option value = "Normal" <?php echo $CalSelNormal; ?> >Normal</option>
                                <option value = "High" <?php echo $CalSelHigh; ?> >High</option>
                                <option value = "Low" <?php echo $CalSelLow; ?> >Low</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div style="padding-top: 40px;" class="form-group form-group-lg">
                <!-- SAVE CHANGES -->
                <div id = "container">
                    <button type="submit" id="save-button" class="btn btn-success btn-lg">Update Account</button>
                    <a data-toggle='modal' href='#' data-target='#deleteModal' id="delete-button" class="btn btn-danger btn-lg">Delete Account</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Start of Delete Account Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Account</h4>
            </div>
            <div class="modal-body">
                <p>Deleting your account will disable some features when comparing future food items. 
                    Are you sure you want to delete your account?
                </p>
            </div>
            <div class="modal-footer">
                <!-- <a class="btn btn-danger" data-dismiss="modal" href="php/deleteAccount.php" role="button">Yes</a>-->
                <a href="php/deleteAccount.php" class="btn btn-danger">Yes</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<?php include "layout/footer.php" ?>
