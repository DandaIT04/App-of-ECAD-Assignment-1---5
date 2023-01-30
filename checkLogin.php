<?php
session_start();

include("header.php");
?>

<?php

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["psw"];

include_once("mysql_conn.php");

$qry = "SELECT * FROM Shopper WHERE Email = ?";

$stmt = $conn->prepare($qry);
$stmt->bind_param("s",$email);

$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) {

	$row1 = $result->fetch_array();

	#if (password_verify($pwd,$row1["Password"]) == true){
    if ($pwd == $row1["Password"]){
        $checkLogin = true;

        $_SESSION["ShopperID"] = $row1["ShopperID"];
        $_SESSION["ShopperName"] = $row1["Name"];

        $qry = "SELECT sc.ShopCartID, COUNT(sci.ProductID) AS NumItems
                FROM shopcart sc LEFT JOIN shopcartitem sci
                ON sc.ShopCartID=sci.ShopCartID
                WHERE sc.OrderPlaced=0 AND sc.ShopperID=?";

        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $_SESSION["ShopperID"]);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $stmt->close();

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_array();
            $_SESSION["Cart"] = $row2["ShopCartID"];
            $_SESSION["NumCartItem"] = $row2["NumItems"];
        }
            
        $theRedirect = "index";
        $Message = "<h3>Logging in as <u>$_SESSION[ShopperName] with Shopper ID of $_SESSION[ShopperID]</u></h3><br>
        <h3>Redirecting to index page in 5 seconds.....</h3>";    
		
    }

    else{
        $theRedirect = "login";
        $Message = "<h3 style='color:red'><u>Invalid</u> Login Credentials </h3><br>
        <h3>Redirecting to login page in 5 seconds.....</h3>";        
    }

}

else {
    $theRedirect = "login";
    $Message = "<h3 style='color:red'><u>Invalid</u> Login Credentials</h3><br>
    <h3>Redirecting to login page in 5 seconds.....</h3>";
}

$conn->close();

?>

<?php
echo $Message;
?>

<script type="text/javascript">

var js_variable  = '<?php echo $theRedirect;?>';

if (js_variable === "login"){
    setTimeout(function () {
        window.location.href= 'login.php'; // the redirect goes here
    },5000);
}

else{
    setTimeout(function () {
        window.location.href= 'index.php'; // the redirect goes here
    },5000);        
}


</script>

<?php

include("footer.php");
?>