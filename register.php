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

<script type="text/javascript">
function validateForm()
{
  if (document.register.countryExists.value.length < 1){
    alert("Country cannot be found in rest countries API");
    return false;
  }

  if (document.register.psw.value.length < 8) {
    alert("password must be at least 8 characters!");
    return false;              // cancel submission    
  }
    // To Do 1 - Check if password matched
	if (document.register.psw.value != document.register.psw2.value) {
    alert("passwords not matched!");
    return false;              // cancel submission
  }

  if (document.register.personAddress.value.length < 8) {
    alert("address must be at least 8 characters!");
    return false;              // cancel submission      
  }

  if (document.register.personName.value.length < 2) {
    alert("address must be at least 2 characters!");
    return false;              // cancel submission      
  }  

  if (document.register.personCountry.value.length < 4) {
    alert("country must be at least 4 characters!");
    return false;              // cancel submission      
  }  

	// To Do 2 - Check if telephone number entered correctly
	//           Singapore telephone number consists of 8 digits,
	//           start with 6, 8 or 9
  if (document.register.personPhone.value != ""){
    var str = document.register.personPhone.value;
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
  }

  if (document.register.personBirth.value != ""){
    
    var d1 = new Date();
    var d2 = new Date(document.register.personBirth.value);

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

<form name="register" action="addMember.php" method="post" onsubmit="return validateForm(this)">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    
    <label for="email"><b>Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <input class="form-control" type="password" placeholder="Enter Password" name="psw" id="psw" required>    

    <label for="psw2"><b>Repeat Password</b></label>
    <input class="form-control" type="password" placeholder="Repeat Password" name="psw2" id="psw2" required>

    <label for="pq"><b>Password Question</b></label>
    <input class="form-control" type="text" placeholder="Enter password question" name="pq" id="pq" required>    

    <label for="pa"><b>Password Answer</b></label>
    <input class="form-control" type="password" placeholder="Enter password answer" name="pa" id="pa" required>   

    <label for="personCountry"><b>Country [Ensure valid country for country code retrieval]</b></label>
    <input class="form-control" type="text" placeholder="Enter Country" name="personCountry" id="personCountry" onchange="checkTheCountry()" required>

    <label for="countryExists"><b>Country/Phone Code [Automatic value retrieved from country]</b></label>
    <input class="form-control" type="text" name="countryExists" id="countryExists" value="" readonly required>

    <label for="personName"><b>Name</b></label>
    <input class="form-control" type="text" placeholder="Enter Name" name="personName" id="personName" required>

    <label for="personBirth"><b>Birthdate</b></label>
    <input class="form-control" type="date" placeholder="Enter Birthdate" name="personBirth" id="personBirth" required>
    <br>
    <label for="personAddress"><b>Address</b></label>
    <input class="form-control" type="text" placeholder="Enter Address" name="personAddress" id="personAddress" required>
    
    <label for="personPhone"><b>Phone</b></label>
    <input class="form-control" type="text" placeholder="Enter Phone" name="personPhone" id="personPhone" required>    
    

    <!-- testing purposes DELETE FROM Shopper WHERE Name='aaa'; -->
    <!--
    <label for="email"><b>Email</b></label>
    <input class="form-control" type="email" placeholder="Enter Email" name="email" id="email" value="fakemail@fakemail.com" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <input class="form-control" type="password" placeholder="Enter Password" name="psw" id="psw" value = "aaaaaaaa" required>    

    <label for="psw2"><b>Repeat Password</b></label>
    <input class="form-control" type="password" placeholder="Repeat Password" name="psw2" id="psw2" value = "aaaaaaaa" required>

    <label for="pq"><b>Password Question</b></label>
    <input class="form-control" type="text" placeholder="Enter password question" name="pq" id="pq" value = "aaa" required>    

    <label for="pa"><b>Password Answer</b></label>
    <input class="form-control" type="password" placeholder="Enter password answer" name="pa" id="pa" value = "aaa" required>   

    <label for="personCountry"><b>Country [Ensure valid country for country code retrieval]</b></label>
    <input class="form-control" type="text" placeholder="Enter Country" name="personCountry" id="personCountry" onchange="checkTheCountry()" required>

    <label for="countryExists"><b>Country/Phone Code [Automatic value retrieved from country]</b></label>
    <input class="form-control" type="text" name="countryExists" id="countryExists" value="" readonly required>

    <label for="personName"><b>Name</b></label>
    <input class="form-control" type="text" placeholder="Enter Name" name="personName" id="personName" value = "aaa" required>

    <label for="personBirth"><b>Birthdate</b></label>
    <input class="form-control" type="date" placeholder="Enter Birthdate" name="personBirth" id="personBirth" value = "1998-06-01" required>
    <br>
    <label for="personAddress"><b>Address</b></label>
    <input class="form-control" type="text" placeholder="Enter Address" name="personAddress" id="personAddress" value = "aaaaaaaa" required>
    
    <label for="personPhone"><b>Phone</b></label>
    <input class="form-control" type="text" placeholder="Enter Phone" name="personPhone" id="personPhone" value = "aaaaaaaa" required>
    -->
    <hr>
    <button type="submit" value="submit" class="registerbtn">Register</button>
    <br>
  </div>
  <br>
  <div class="container signin">
    <br>
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
    <br>
  </div>
</form>

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