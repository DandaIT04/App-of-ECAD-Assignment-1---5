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

<form name="login" action="checkLogin.php" method="post">
  <div class="container">
    <h1>Login</h1>
    <hr>

    <label for="email"><b>Email</b></label>
    <input class="form-control" type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input class="form-control" type="password" placeholder="Enter Password" name="psw" id="psw" required>  

    <br>

    <button type="submit" class="registerbtn">Login</button>
  </div>
  
  <hr>
  <div class="container signin">
    <br>
    <p>No account? <a href="register.php">Create Account</a>.</p>

    <p>Forgot Password? <a href="forgotPassword.php">Recover Password</a>.</p>
  </div>
</form>

<!-- <img src="Images/welcome2mamaya.jpg" class="img-fluid" 
     style="display:block; margin:auto;"/>"; -->

<?php 
include("promotion.php");
// Include the Page Layout footer
include("footer.php"); 
?>