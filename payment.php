<?php 
namespace Checkout;
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.
include_once("cartFunction.php");
include_once("mysql_conn.php"); 
include("header.php"); // Include the Page Layout header
echo "<div id='payment' style='margin:auto'>"; // Start a container
echo "<p class='page-title' style='text-align:center'>Payment</p>";

$subTotal = $_SESSION["SubTotal"];

if (isset($_POST["deliverType"])) {
    $deliveryType = $_POST["deliverType"];
    if ($_POST["deliverType"] == "normal") {
        $_SESSION["Delivery"] = 5;
    } else if ($_POST["deliverType"] == "express") {
        $_SESSION["Delivery"] = 10;
    }
}
$delivery = $_SESSION["Delivery"];
$tax = round($_SESSION["SubTotal"]*0.08, 2);
$_SESSION["TotalAmt"] = $subTotal + $delivery + $tax;
$totalAmt = $_SESSION["TotalAmt"];


echo "<p style='text-align:left; font-size:20px'>Subtotal = S$". number_format($subTotal, 2);
echo "<p style='text-align:left; font-size:20px'>Delivery = S$". number_format($delivery, 2);
echo "<p style='text-align:left; font-size:20px'>Tax = S$". number_format($tax, 2);
echo "<p style='text-align:left; font-size:20px'>Total Amount = S$". number_format($totalAmt, 2);


// Add PayPal Checkout button on the shopping cart page
echo "<form method='post' action='checkoutProcess.php'>";
echo "<input type='image' style='float:right;'
        src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
echo "</form></p>";


echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>