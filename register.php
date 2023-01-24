<?php 
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 
?>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>

<form name="register" action="addMember.php" method="post">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
    
    <label for="personName"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="personName" id="personName" required>

    <label for="personAddress"><b>Address</b></label>
    <input type="text" placeholder="Enter Address" name="personAddress" id="personAddress" required>
    
    <label for="personCountry"><b>Country</b></label>
    <input type="text" placeholder="Enter Country" name="personCountry" id="personCountry" required>
    
    <label for="personPhone"><b>Phone</b></label>
    <input type="text" placeholder="Enter Phone" name="personPhone" id="personPhone" required>    

    <hr>

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>

<!-- <img src="Images/welcome2mamaya.jpg" class="img-fluid" 
     style="display:block; margin:auto;"/>"; -->

     <div class="product-slider">
  <div id="carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="item active"> <img src="Images/Slider_Index/1.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/2.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/3.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/4.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/5.png"> </div>
      <!-- <div class="item"> <img src="http://placehold.it/1600x700?text=Product+06"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+07"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+08"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+09"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+10"> </div> -->
    </div>
  </div>
</div>


<?php 
// Include the Page Layout footer
include("footer.php"); 
?>