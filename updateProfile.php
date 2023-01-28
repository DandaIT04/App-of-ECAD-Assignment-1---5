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

<?php

include_once("mysql_conn.php");

$tempQryCheck = "SELECT * FROM Shopper WHERE ShopperID = ?";

$tempCheck = $conn->prepare($tempQryCheck);

$tempCheck->bind_param("s",$_SESSION['ShopperID']);

$tempCheck -> execute();

$tempResult = $tempCheck->get_result();
$tempCheck -> close();

$theRow = $tempResult->fetch_array();

$_SESSION['tempUpdateEmail'] = $theRow['Email'];
$_SESSION['tempUpdatePassword'] = $theRow['Password'];
$_SESSION['tempUpdatePwdQ'] = $theRow['PwdQuestion'];
$_SESSION['tempUpdatePwdA'] = $theRow['PwdAnswer'];
$_SESSION['tempUpdateName'] = $theRow['Name'];
$_SESSION['tempUpdateBirthdate'] = $theRow['BirthDate'];
$_SESSION['tempUpdateAddress'] = $theRow['Address'];
$_SESSION['tempUpdateCountry'] = $theRow['Country'];
$_SESSION['tempUpdatePhone'] = $theRow['Phone'];

?>

<script type="text/javascript">    

function validateForm()
{
  if (document.updateProfile.countryExists.value != ""){
    if (document.updateProfile.countryExists.value.length < 1){
      alert("Country cannot be found in rest countries API");
      return false;
    }
    if (document.updateProfile.personPhone.value.length < 1){
      alert("Update your phone particulars!");
      return false;
    }    
  }

  if (document.updateProfile.psw.value != "") {
      if (document.updateProfile.psw.value.length < 8) {
          alert("password must be at least 8 characters!");
          return false;              // cancel submission 
      }
      if (document.updateProfile.psw2.value.length < 8) {
          alert("password must be at least 8 characters!");
          return false;              // cancel submission 
      }
      if (document.updateProfile.psw3.value.length < 8) {
          alert("password must be at least 8 characters!");
          return false;              // cancel submission 
      }
      if (document.updateProfile.psw1.value != document.updateProfile.psw2.value){
          alert("password does not match!!");
          return false;              // cancel submission             
      }                                   
  }

  if(document.updateProfile.personAddress.value != ""){
      if (document.updateProfile.personAddress.value.length < 8) {
      alert("address must be at least 8 characters!");
      return false;              // cancel submission      
  }        
  }

  if(document.updateProfile.personCountry.value.length > 0){
      if (document.updateProfile.personCountry.value.length < 4) {
        alert("country must be at least 4 characters!");
        return false;              // cancel submission
      }     
      if(document.updateProfile.countryExists.value.length<1){
        alert("Due to country change, please wait for code assignment");
        return false;         
      }
      if(document.updateProfile.personPhone.value.length<1){
        alert("Due to country change, please input phone number");
        return false;         
      } 
  } 
  

  if (document.updateProfile.personName.value != ""){
      if (document.updateProfile.personName.value.length < 2) {
      alert("address must be at least 2 characters!");
      return false;              // cancel submission      
  } 
  }
  

  if (document.updateProfile.personPhone.value != ""){
    var str = document.updateProfile.personPhone.value;
    if (str.length != 8) {
      alert("Please enter a 8-digit phone number.");
      return false;

    }
                    // cancel submission
    else if (str.substr(0,1) != "6" &&
      str.substr(0,1) != "8" &&
      str.substr(0,1) != "9" ) {
      alert("phone number in Singapore should start with 6, 8 or 9.");
      return false; // cancel submission
    }

    if (document.updateProfile.personCountry.value.length<4){
      if(document.updateProfile.countryExists.value.length<1){
        alert("Due to phone change, please input country and wait for code assignment");
        return false;         
      }
    }
  }
    
  if (document.updateProfile.personBirth.value != ""){
  
  var d1 = new Date();
  var d2 = new Date(document.updateProfile.personBirth.value);

  var same = d1.getTime() === d2.getTime();

  if (same === true){
    alert("Invalid date!"); 
    return false;      
  }

  else if(same === false){
    var age = d1.getFullYear() - d2.getFullYear();

    if (age >= 16){
      return true;
    }

    else{
      alert("You must be above 16 to register!"); 
      return false;  
    }

  }   
  }    
    

  return true;  // No error found
}

</script>

<form name="updateProfile" action="updateProfile.php" method="post" onsubmit="return validateForm(this)">
  <div class="container">
    <h1>Update Profile</h1>
    <hr>

    <label for="email"><b>Email</b></label>
    <input class="form-control" type="email" placeholder="<?php echo $_SESSION['tempUpdateEmail']?>" name="email" id="email">
    <br>
    <label for="psw"><b>Current Password [Required if changing password]</b></label>
    <input class="form-control" type="password" placeholder="Current Password" name="psw" id="psw">    

    <label for="psw2"><b>New Password</b></label>
    <input class="form-control" type="password" placeholder="New Password" name="psw2" id="psw2">

    <label for="psw3"><b>Repeat Password</b></label>
    <input class="form-control" type="password" placeholder="Repeat New Password" name="psw3" id="psw3">

    <label for="pq"><b>Password Question</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['tempUpdatePwdQ']?>" name="pq" id="pq">    

    <label for="pa"><b>Password Answer</b></label>
    <input class="form-control" type="password" placeholder="<?php echo $_SESSION['tempUpdatePwdA']?>" name="pa" id="pa">   

    <label for="personCountry"><b>Country</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['tempUpdateCountry']?>" name="personCountry" id="personCountry" onchange="checkTheCountry()">

    <label for="countryExists"><b>Country/Phone Code [Automatic value retrieved from country]</b></label>
    <input class="form-control" type="text" name="countryExists" id="countryExists" value="" readonly>

    <label for="personName"><b>Name</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['tempUpdateName']?>" name="personName" id="personName">

    <label for="personBirth"><b>Birthdate [Current Birthdate: <?php echo $_SESSION['tempUpdateBirthdate']?>]</b></label>
    <input class="form-control" type="date" placeholder="" name="personBirth" id="personBirth">
    <br>
    <label for="personAddress"><b>Address</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['tempUpdateAddress']?>" name="personAddress" id="personAddress">
    
    <label for="personPhone"><b>Phone</b></label>
    <input class="form-control" type="text" placeholder="<?php echo $_SESSION['tempUpdatePhone']?>" name="personPhone" id="personPhone">    
    
    <hr>
    <button type="submit" value="submit" class="registerbtn">Update Profile</button>
    <br>
  </div>
  <br>
</form>


<?php

if (!empty($_POST))
{
    $name = $_POST["personName"];
    $address = $_POST["personAddress"];
    $country = $_POST["personCountry"];
    $birthdate = $_POST["personBirth"];
    $phone = $_POST["countryExists"]." ".$_POST["personPhone"];
    $email = $_POST["email"];
    $pwdquestion = $_POST["pq"];
    $password = $_POST["psw"];
    $password1 = $_POST["psw2"];
    $password2 = $_POST["psw3"];
    $pwdanswer = $_POST["pa"];

    $my_array = array($name,$address,$country,$birthdate,$phone,$email,$pwdquestion,$password,
    $pwdanswer);

    $to_query = array($_SESSION['tempUpdateName'],$_SESSION['tempUpdateAddress'],$_SESSION['tempUpdateCountry'],
    $_SESSION['tempUpdateBirthdate'],$_SESSION['tempUpdatePhone'],$_SESSION['tempUpdateEmail'],
    $_SESSION['tempUpdatePwdQ'],$_SESSION['tempUpdatePassword'],$_SESSION['tempUpdatePwdA']);

    $insert_array = array("UPDATE Shopper SET Name=? WHERE ShopperID=?",
    "UPDATE Shopper SET Address=? WHERE ShopperID=?","UPDATE Shopper SET Country=? WHERE ShopperID=?",
    "UPDATE Shopper SET BirthDate=? WHERE ShopperID=?","UPDATE Shopper SET Phone=? WHERE ShopperID=?",
    "UPDATE Shopper SET Email=? WHERE ShopperID=?","UPDATE Shopper SET PwdQuestion=? WHERE ShopperID=?",
    "UPDATE Shopper SET Password=? WHERE ShopperID=?","UPDATE Shopper SET PwdAnswer=? WHERE ShopperID=?");

    for ($x = 0; $x <= count($my_array); $x++) {
        if (isset($my_array[$x])){
            if ($my_array[$x] != null){
                $qry = $insert_array[$x];

                if ($x == 4){
                  if($my_array[$x] == $to_query[$x]){
                    echo "<h3 style='color:red'>$my_array[$x] same as $to_query[$x]!</h3><br>";
                }
                else{
                    if(strlen($my_array[$x]) > 1){

                      $theRedirect = "goredirect"; 
  
                      $stmt = $conn->prepare($qry);
                      $stmt->bind_param("ss",$my_array[$x],$_SESSION["ShopperID"]);
                      $stmt->execute();
                      $stmt->close();
                      
                      echo "<h3>$to_query[$x] changed to $my_array[$x] and its 4</h3><br>";
  
                      $URL="updateProfile.php";
                      //echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                    }
                   
                  }
                }

                elseif ($x == 5){
                    if ($email == $_SESSION['tempUpdateEmail']){
                        echo "<h3 style='color:red'>Same Email detected!</h3><br>";
                    }
                    else{
                        $theRedirect = "goredirect";

                        $stmt = $conn->prepare($qry);
                        $stmt->bind_param("ss",$my_array[$x],$_SESSION["ShopperID"]);
                        $stmt->execute();
                        $stmt->close();

                        echo "<h3>Email changed!</h3><br>";

                        $URL="updateProfile.php";
                        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                    }    
                }
                elseif ($x == 7){
                    if ($password != $_SESSION['tempUpdatePassword']){
                        echo "<h3 style='color:red'>Wrong Password detected!</h3><br>";
                    }
                    elseif($password == $_SESSION['tempUpdatePassword']){
                        if ($password1 != $password2){
                            echo "<h3 style='color:red'>New passwords mismatch!</h3><br>";
                        }
                        elseif($password1 == $password2){
                            $theRedirect = "goredirect";

                            $stmt = $conn->prepare($qry);
                            $stmt->bind_param("ss",$my_array[$x],$_SESSION["ShopperID"]);
                            $stmt->execute();
                            $stmt->close();
    
                            echo "<h3>Password changed!</h3><br>";
                            
                            $URL="updateProfile.php";
                            echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";                            
                        }
                    }
                }
                else{
                    if($my_array[$x] == $to_query[$x]){
                        echo "<h3 style='color:red'>$my_array[$x] same as $to_query[$x]!</h3><br>";
                    }
                    else{
                        $theRedirect = "goredirect"; 

                        $stmt = $conn->prepare($qry);
                        $stmt->bind_param("ss",$my_array[$x],$_SESSION["ShopperID"]);
                        $stmt->execute();
                        $stmt->close();
                        
                        echo "<h3>$to_query[$x] changed to $my_array[$x]</h3><br>";

                        $URL="updateProfile.php";
                        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                       
                    }
                }

            }

        }
    }

}

?>

<script type="text/javascript">

function checkTheCountry() {
  document.getElementById("countryExists").value = "";
  var x = document.getElementById("personCountry").value;

  let myJson;

  let newJson;

  linkOne = "https://restcountries.com/v2/name/";
  linkTwo = x;

  finalLink = linkOne.concat(linkTwo);

  fetch(finalLink)
  .then(response => response.json())
  .then((data) => {
    myJson = data;
  });

  function data () {
    if(myJson == undefined){
    }
    else{
      let discovered = false;
      let discovered1 = false;
      for (i in myJson){
        if (discovered === false && discovered1 === false){
          if (myJson[i].callingCodes != undefined){
            newJson = JSON.stringify(myJson[i].callingCodes);
            if (newJson != ""){
              discovered = true;

              firstBracket = "(";
              secondBracket = ")";

              newJson = newJson.replace(/[^a-zA-Z0-9 ]/g, '');

              firstBracket = firstBracket.concat(newJson);
              
              firstBracket = firstBracket.concat(secondBracket);

              
              document.getElementById("countryExists").value = firstBracket;
            }
          }
          if (myJson[i].name != undefined){
            newJson = JSON.stringify(myJson[i].name);
            if(newJson != ""){
              discovered1 = true;

              document.getElementById("personCountry").value = newJson.replace(/[^a-zA-Z0-9 ]/g, '');
            }
          }
        }
        else{
          clearInterval(loadData);
          break;
        }


      }
      clearInterval(loadData);
      /*
      clearInterval(loadData);

      alert(newJson);

      for (i in newJson){
        if(newJson[i] != undefined){
          alert(newJson[i]);
        }

        */
      
    }
  }
  
  const loadData = setInterval(data,1000);

}

</script>


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