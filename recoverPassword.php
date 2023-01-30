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

<form name="recoverPassword" action="recoverPassword.php" method="post">

<div class="container">
    <h1>Recover Password</h1>
    <hr>

    <label for="email" hidden><b>Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email" value="<?php echo $_SESSION['theEmail']?>" hidden>
    <label for="pq"><b>Password Question</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['theQ']?>" name="pq" id="pq" value="<?php echo $_SESSION['theQ']?>">  
    <br>
    <label for="pa"><b>Enter Password Answer</b></label>
    <input class="form-control" type="password" placeholder="Enter Password answer" name="pa" id="pa"required>    

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
                
                $_SESSION["theRecover"] = "";
                
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


include("promotion.php");
include("footer.php");
?>