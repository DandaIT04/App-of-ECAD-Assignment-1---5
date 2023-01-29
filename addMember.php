<?php
session_start();

include("header.php");
?>

<?php

$name = $_POST["personName"];
$address = $_POST["personAddress"];
$country = $_POST["personCountry"];
$birthdate = $_POST["personBirth"];
$phone = $_POST["countryExists"]." ".$_POST["personPhone"];
$email = $_POST["email"];
$pwdquestion = $_POST["pq"];
$password = $_POST["psw"];
$pwdanswer = $_POST["pa"];

//$password = $_POST["password"];

#$password = password_hash($_POST["psw"], PASSWORD_DEFAULT);
#$pwdanswer = password_hash($_POST["pa"], PASSWORD_DEFAULT);

include_once("mysql_conn.php");

$tempQryCheck = "SELECT Email FROM Shopper WHERE Email = ?";

$tempCheck = $conn->prepare($tempQryCheck);
$tempCheck->bind_param("s",$email);

$tempCheck -> execute();

$tempResult = $tempCheck->get_result();
$tempCheck-> close();

if ($tempResult -> num_rows == 1){
    $Message = "<h3 style='color:red'>Email already <u>exists!</u><br><br>Redirecting in 5 seconds....</h3><br>";

    $theRedirect = "register";
    
}

else{
    $qry = "INSERT INTO Shopper (Name,BirthDate,Address, 
    Country,Phone,Email,Password,PwdQuestion,PwdAnswer)
     VALUES (?,?,?,?,?,?,?,?,?)";
    
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("sssssssss",$name,$birthdate,$address,$country,$phone,$email,$password,$pwdquestion,$pwdanswer);
    
    if ($stmt->execute()) {
    
        $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
        $result = $conn->query($qry);
        while ($row = $result->fetch_array()) {
            $_SESSION["ShopperID"] = $row["ShopperID"];
        }

        $_SESSION["ShopperName"] = $name;      
    
        $Message = "<h3>Registration <u>successful!</u><br /><br /> 
        Logging in as $_SESSION[ShopperName] with Shopper ID of $_SESSION[ShopperID]....<br /><br />
        Redirecting in 5 seconds....</h3><br />";
               
    }
    $stmt->close();
   
    $theRedirect = "index";
       
}

$conn->close();
?>

<?php
echo $Message;
?>

<script type="text/javascript">

var js_variable  = '<?php echo $theRedirect;?>';

if (js_variable === "register"){
    setTimeout(function () {
        window.location.href= 'register.php'; // the redirect goes here
    },5000);
}

else{
    setTimeout(function () {
        window.location.href= 'index.php'; // the redirect goes here
    },5000);        
}


</script>

<?php
include("promotion.php");
include("footer.php");
?>