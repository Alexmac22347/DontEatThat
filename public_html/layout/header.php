<?php
    session_start();
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?> &#8226; Don't Eat That!</title>
        <meta charset="utf-8">
        <!-- Ensure proper rendering on mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Link to an external style sheet -->
        <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- jQuery Validation Plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
        <!-- jQuery Validation Plugin: Additional Methods -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="vendors/bootstrap/js/bootstrap.min.js"></script>
        <!-- Custom jquery functions -->
        <script src="js/jQueryFunctions.js"></script>
        <!-- Script to send email -->
        <script src="js/contact.js"></script>
        <!-- Script to retrieve food data from API -->
        <script src="foodquery.php"></script>
    </head>
    <body>
        <!-- Navbar setup -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- DET Logo on navbar -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#theNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a href="index.php">
                    <img class="navbar-brand" src="res/greylogo.png">
                    </a>
                </div>
                <!-- End of DET Logo on navbar -->
                <div class="navbar-collapse collapse" id="theNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="about.php">About</a></li>
                        <li><a href="howItWorks.php">How It Works</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                    <div>
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if (isset($_SESSION["user_name"])) {
                                    echo 
                                    "
                                    <li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' type='button' data-toggle='dropdown'>
                                        <span class='glyphicon glyphicon-user'></span> " . $_SESSION['user_name'] . " <span class='caret'></span>
                                        </a>
                                        <ul class='dropdown-menu'>
                                            <li><a href='../manageAccount.php'><span class='glyphicon glyphicon-cog'></span> Manage Account</a></li>
                                            <li><a href='../php/logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>
                                        </ul>
                                    </li>
                                    ";
                                } else {
                                    echo 
                                    "
                                    <li><a href='signup.php'><span class='glyphicon glyphicon-user'></span> Signup</a></li>
                                    <li><a data-toggle='modal' href='#' data-target='#loginModal'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
                                    ";
                                } 
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- End of navbar setup -->
        <!-- Beginning of Login Modal -->
        <div id="loginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Login</h3>
                    </div>
                    <div class="modal-body">
                        <div id="loginErr"></div>
                        <form id="loginForm" method="post" action="login.php" name="login_form">
                            <div class="form-group">
                                <label for="login-username">Username</label>
                                <input id="login-username" class="form-control" type="text" placeholder="Enter Username" name="login-username">
                            </div>
                            <div class="form-group">
                                <label for="login-password">Password</label>
                                <input id="login-password" class="form-control" type="password" placeholder="Enter Password" name="login-password">
                            </div>
                            <button id="login_button" type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a id="reg_button" href="signup.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Login Modal -->
