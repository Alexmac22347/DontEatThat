<?php
// PLEASE DO NOT RUN DIRECTLY, USE THE 'runDatabaseTests.sh' SCRIPT

// Check to make sure we're logged in first
if(!isset($_SESSION['Username'])) {
    echo "Logout test not possible. User not logged in!\n";
    return -1;
}

if(!isset($_SESSION['Name'])) {
    echo "Logout test not possible. User not logged in!\n";
    return -1;
}

// Now call the logout script
require('logout.php');

if(isset($_SESSION['Username']) || isset($_SESSION['Name'])) {
    echo "logout.php failed: user is still logged in as " . $_SESSION['Username'] . "\n";
    return -1;
}

echo "logout.php tests passed succesfully\n";
return 0;

?>
