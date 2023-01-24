<?php
session_start();

include("header.php");
?>

<style>
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
</style>

<form name="register" action="forgotPassword.php" method="post">

<div class="container">
    <h1>Recover Password</h1>
    <hr>

    <label for="email"><b>Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email"required>
    <br>
    <label for="pq"><b>Enter Password Question</b></label>
    <input class="form-control" type="text" placeholder="Enter Password question" name="pq" id="pq"required>  
    <br>
    <label for="pa"><b>Enter Password Answer</b></label>
    <input class="form-control" type="password" placeholder="Enter Password answer" name="pa" id="pa"required>    

    <!-- testing purposes -->
    <!--
    <label for="email"><b>Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email" value="fakemail@fakemail.com" required>
    <br>
    <label for="pq"><b>Enter Password Question</b></label>
    <input class="form-control" type="text" placeholder="Enter Password question" name="pq" id="pq" value = "aaa" required>  

    <label for="pa"><b>Enter Password Answer</b></label>
    <input class="form-control" type="password" placeholder="Enter Password answer" name="pa" id="pa" value = "aaa" required> 
    -->

    <hr>
    <button type="submit" value="submit" class="registerbtn">Recover Password</button>
    <br>

</div>    

</form>



<?php

if (!empty($_POST))
{
    if ($_POST["email"] != ""  && $_POST["pq"] != "" && $pa = $_POST["pa"]){
        include_once("mysql_conn.php");
        // Reading inputs entered in previous page
        $email = $_POST["email"];
        $pq = $_POST["pq"];
        $pa = $_POST["pa"];
    
        $qry = "SELECT * FROM Shopper WHERE Email = ?";
    
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("s",$email);
    
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        if ($result->num_rows > 0) {
    
            $row1 = $result->fetch_array();
    
            if ($pq == $row1["PwdQuestion"] &&
            $pa == $row1["PwdAnswer"]){
    
                $checkLogin = true;
    
                $_SESSION["theRecover"] = $row1["Password"];
    
                $Message = "    <h3>Your password is : <u>$_SESSION[theRecover]</u></h3>";    
                
            }
    
            else{
                $Message = "<h3 style='color:red'><u>Invalid</u> Password question or/and answer </h3><br>";        
            }
    
        }
    
        else {
            $Message = "<h3 style='color:red'><u>Invalid</u> Email</h3><br>";
        }
    
        $conn->close();
    
    }
    echo $Message;

}

?>

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
include("footer.php");
?>