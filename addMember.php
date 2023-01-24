<?php
session_start();

$name = $_POST["personName"];
$address = $_POST["personAddress"];
$country = $_POST["personCountry"];
$birthdate = $_POST["personBirth"];
$phone = $_POST["personPhone"];
$email = $_POST["email"];
$pwdquestion = $_POST["pq"];

//$password = $_POST["password"];

$password = password_hash($_POST["psw"], PASSWORD_DEFAULT);
$pwdanswer = password_hash($_POST["pa"], PASSWORD_DEFAULT);

include_once("mysql_conn.php");

$tempQryCheck = "SELECT * FROM Shopper WHERE Email = ? 
VALUES (?)";

$tempCheck = $conn->prepare($tempQryCheck);
$tempCheck->bind_param("ssssss",$email);

if ($tempCheck -> execute()){
    if ($tempCheck -> num_rows == 1){
        $Message = "<h3 style='color:red'>Email already exists!</h3>";
    }
    else{
        $qry = "INSERT INTO Shopper (Name,BirthDate,Address, 
        Country,Phone,Email,Password,PwdQuestion,PwdAnswer)
         VALUES (?,?,?,?,?,?,?,?,?)";
        
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("ssssss",$name,$birthdate,$address,$country,$phone,$email,$password,$pwdquestion,$pwdanswer);
        
        if ($stmt->execute()) {
        
            $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
            $result = $conn->query($qry);
            while ($row = $result->fetch_array()) {
                $_SESSION["ShopperID"] = $row["ShopperID"];
            }
        
            $Message = "Registration successful!<br />
                        Your ShopperID is $_SESSION[ShopperID]<br />";
        
            $_SESSION["ShopperName"] = $name;            
        }
    }
}

$stmt->close();
$conn->close();

include("header.php");

echo $Message;

include("footer.php");

?>