<?php 
    $title = "";
    include("layout/header.php"); 
?>

<div style="padding-left: 5%;padding-right:5%;">
    <div class="container-fluid">
        <div style="padding-top: 30px;" align="center">
            <?php
                echo $_SESSION['countdown_message']
            ?>
            <b>
                You will be redirected in 
                <p style="display:inline; padding:0px;" id="number"></p>
                Seconds
            </b>
            <script type="text/javascript" src="js/countdown.js"></script>
        </div>
    </div>
</div>

<?php include "layout/footer.php" ?>
