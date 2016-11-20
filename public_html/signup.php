<?php
    $title = "Sign Up";
    include("layout/header.php");
    
    // Server-Side Error Handling on Submit
    $url                  = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // used in determining if we need to display errors
    // Initialize to state with no errors
    $errorName            = $errorUsername = $errorPassword = false;
    $errorInvalidName     = false;
    $errorInvalidUsername = $errorUsernameExists = false;
    $errorInvalidPassword = false;
    // Determine if we need to display errors
    if (strpos($url, 'errorName=empty') !== false) {
        $errorName = true;
    }
    if (strpos($url, 'errorName=invalid') !== false) {
        $errorInvalidName = true;
    }
    if (strpos($url, 'errorUsername=empty') !== false) {
        $errorUsername = true;
    }
    if (strpos($url, 'errorUsername=invalid') !== false) {
        $errorInvalidUsername = true;
    }
    if (strpos($url, 'errorUsername=exists') !== false) {
        $errorUsernameExists = true;
    }
    if (strpos($url, 'errorPassword=empty') !== false) {
        $errorPassword = true;
    }
    if (strpos($url, 'errorPassword=invalid') !== false) {
        $errorInvalidPassword = true;
    }
    ?>
<div class="container-fluid">
    <form id="signupForm" class="form-horizontal" action="php/makeAccount.php" method="post">
        <h2 style="padding-left: 0;">Registration Form</h2>
        <!-- NAME -->
        <div class="form-group">
            <label for="signup-name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" placeholder="Enter Name" id="signup-name" name="signup-name"
                    value="<?php echo $_SESSION['signupname']; ?>" autofocus>
                <?php
                    // SERVER-SIDE VALIDATION FOR NAME
                    if ($errorName !== false) {
                        echo "<label class='error'>Please enter your name.</label>";
                    } else if ($errorInvalidName !== false) {
                        echo "<label class='error'>Name must contain only alphabetical letters.</label>";
                    }
                    ?>
            </div>
        </div>
        <!-- USERNAME -->
        <div class="form-group">
            <label for="signup-username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" placeholder="Enter Username" id="signup-username" name="signup-username"
                    value="<?php echo $_SESSION['signupusername']; ?>">
                <?php
                    // SERVER-SIDE VALIDATION FOR USERNAME
                    if ($errorUsername !== false) {
                        echo "<label class='error'>Please enter your username.</label>";
                    } else if ($errorInvalidUsername !== false) {
                        echo "<label class='error'>Username must be 3-16 characters long and contain only numbers and/or letters.</label>";
                    } else if ($errorUsernameExists !== false) {
                        echo "<label class='error'>Username already exists.</label>";
                    }
                    ?>
            </div>
        </div>
        <!-- PASSWORD -->
        <div class="form-group">
            <label for="signup-password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-4">
                <input class="form-control" type="password" placeholder="Enter Password" id="signup-password" name="signup-password">
                <?php
                    // SERVER-SIDE VALIDATION FOR PASSWORD
                    if ($errorPassword !== false) {
                        echo "<label class='error'>Please enter your password.</label>";
                    } else if ($errorInvalidPassword !== false) {
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
                    <select class="form-control" name="signup-calories">
                        <option>Normal</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="col-sm-2">Sugar</label>
                    <select class="form-control" name="signup-sugar">
                        <option>Normal</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="col-sm-2">Sodium</label>
                    <select class="form-control" name="signup-sodium">
                        <option>Normal</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="col-sm-2">Protein</label>
                    <select class="form-control" name="signup-protein">
                        <option>Normal</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label class="col-sm-2">Calcium</label>
                    <select class="form-control" name="signup-calcium">
                        <option>Normal</option>
                        <option>High</option>
                        <option>Low</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="padding-top: 40px;" align="center">
            <button type="submit" id="register-button" class="btn btn-primary">Register</button>
        </div>
    </form>
</div>
<!--End of Form-->
<?php include "layout/footer.php"; ?>
