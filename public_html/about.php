<?php 
    $title = "About";
    include("layout/header.php"); 
?>
<!-- Beginning of About content -->
<div align="center" style="padding-top: 2%;">
   <div class="container-fluid">
      <h2>About Don't Eat That!</h2>
      <p align="left" class="about-description">
         This web application was originally developed for a group project in CPEN 321 - Software Engineering. The idea for this
         web application came from the book "Eat This, Not That!". The book is a nutritional guide that compares foods from the 
         same genre and recommends the healthier choices. However, we felt that the book had several shortcomings. First, the book
         had a rather limited selection of foods, with approximately 12 per genre. All the choices were displayed together, making it 
         difficult for a user to compare two choices side by side.
      </p>
      <p align="left" class="about-description">    
         Don't Eat That! was developed to allow a user to compare a wide variety of foods side by side. The Web Application displays
         the nutritional information of the user's inputs and also recommends the healthier choice for the user's needs. 
      </p>
   </div>
</div>
<!-- End of About content -->
<?php include "layout/footer.php" ?>
