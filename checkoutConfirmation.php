<?php 
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.
include_once("cartFunction.php");
include("header.php"); // Include the Page Layout header

if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

echo "<div id='orderSummary' style='margin:auto'>"; // Start a container
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT *, (Price*Quantity) AS Total
			FROM ShopCartItem WHERE ShopCartID=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]); // "i" - integer
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// the page header and header row of shopping cart page
		echo "<p class='page-title' style='text-align:center'>Order Summary</p>"; 
		echo "<div class='table-responsive' >"; // Bootstrap responsive table
		echo "<table class='table table-hover'>"; // Start of table
		echo "<thead class='cart-header'>"; //Start of table's header section
		echo "<tr>"; //Start of header row
		echo "<th width='250px'>Item</th>";
		echo "<th width='90px'> Price (S$)</th>";
		echo "<th width='60px'>Quantity</th>";
		echo "<th width='80px'>Total (S$)</th>";
		echo "</tr>"; //End of header row
		echo "</thead>"; //End of table's header section

		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"]=array();

		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		$subTotalQuantity = 0;
		echo "<tbody>"; // Start of table's body section
		while ($row = $result->fetch_array()) {
			echo "<tr>";
			echo "<td style='width:50%'>$row[Name]<br />";
			$formattedPrice = number_format($row["Price"], 2);
			echo "<td>$formattedPrice</td>";
			echo "<td>$row[Quantity]</td>";

			$formattedTotal = number_format($row["Total"], 2);
			echo "<td>$formattedTotal</td>";

			
			echo "&nbsp;";
			echo "&nbsp;";
			echo "</form>";
			echo "</td>";
			echo "</tr>";

		    // Store the shopping cart items in session variable as an associate array
			$_SESSION["Items"][] = array("productId"=>$row["ProductID"],
									"name"=>$row["Name"],
									"price"=>$row["Price"],
									"quantity"=>$row["Quantity"]);
			// Accumulate the running sub-total
			$subTotal += $row["Total"];

			// Accumulate the running sub-total
			$formattedQuantity = number_format($row["Quantity"], 2);
			$subTotalQuantity += $row["Quantity"];
		}
		echo "</tbody>"; // End of table's body section
		echo "</table>"; // End of table
		echo "</div>"; // End of Bootstrap responsive table
		$_SESSION["SubTotal"] = round($subTotal, 2);
		
		// Total Quantity in Cart
		echo "<p style='text-align:right; font-size:15px'>
			  Total Quantity is ". number_format($subTotalQuantity);
		$_SESSION["SubTotalQ"] = round($subTotalQuantity);
		echo "<br>";
		echo "<p style='text-align:right; font-size:20px'>
			  	Subtotal = S$". number_format($subTotal, 2);
		echo "<br>";
		echo "<br>";

		// Delivery Chargings
		if ($_SESSION["SubTotal"] > 200) {
			echo "<br>";
			echo "<p style='text-align:left; font-size:15px; color:red;' > Delivery Charges are waived for orders above $200";
		}
		else {
			echo "<p style='text-align:left; font-size:20px'><strong> Please select your delivery mode: </strong>";
			echo "<br>";
			echo "<form style='text-align:left;' action='' method='post'>";
			echo "<label style='font-size:16px'>";
			echo "<input style='margin:10px' method='post' type='radio' name='deliverType' value='standard' checked> Normal Delivery (S$5.00)";
			echo "<p style='text-align:left; margin:10px; font-size:14px'><em>Delivered within 2 working days after your order is placed. </em>";
			echo "</label>";
			echo "<br>";
			echo "<br>";
			echo "<label style='font-size:16px'>";
			echo "<input method='post' type='radio' name='deliverType' value='express'> Express Delivery (S$10.00)";
			echo "<p style='text-align:left; margin:10px; font-size:14px'><em> Delivered within 24 hours after an order is placed.</em>";
			echo "</label>";
			echo "</form>";

			if (isset($_POST["deliverType"])) {
				$delivery = $_POST["deliverType"];  
				if ($delivery == "standard") {
					echo "<p style='text-align:right; font-size:20px'>
							Subtotal = S$". number_format(($_SESSION["SubTotal"] + 5), 2);
				}
				else if ($delivery == "express"){
					echo "<p style='text-align:right; font-size:20px'>
							Subtotal = S$". number_format(($_SESSION["SubTotal"] + 10), 2);
				}
			}
		}
		echo "<br>";
		echo "<br>";

	}
		//Shipping Address
		//Get details for user
		$tempQryCheck = "SELECT * FROM Shopper WHERE ShopperID = ?";

		$tempCheck = $conn->prepare($tempQryCheck);

		$tempCheck->bind_param("s",$_SESSION['ShopperID']);

		$tempCheck -> execute();

		$tempResult = $tempCheck->get_result();
		$tempCheck -> close();

		$theRow = $tempResult->fetch_array();
		$tempName = $theRow['Name'];
		$tempPhone = $theRow['Phone'];
		$tempEmail = $theRow['Email'];
		$tempAddress = $theRow['Address'];

		//Address form
		echo "<div class='wrapper' style='width:auto'>";
		echo "<p style='text-align:left; font-size:20px'><strong>Shipping Address </strong>";
		echo "<form method='get' id='addressForm'>";

		//Name
		echo "<div style='margin:10px'>";
		echo "<label for='name' style='font-size:16px'>Name: </label><br>";
		echo "<input style='width:150%' type='text' id='name' name='name' value='$tempName' autocomplete='name' required enterkeyhint='next'>";
		echo "</div>";

		//Phone Number
		echo "<div style='margin:10px'>";
		echo "<label for='phone' style='font-size:16px'>Phone Number: </label><br>";
		echo "<input style='width:150%' type='tel' id='phone' name='phone' value='$tempPhone' autocomplete='phone' required enterkeyhint='next'></input>";
		echo "</div>";

		//Email
		echo "<div style='margin:10px'>";
		echo "<label for='email' style='font-size:16px'>Email: </label><br>";
		echo "<input style='width:150%' type='email' id='email' name='email' value='$tempEmail' autocomplete='email' required enterkeyhint='next'></input>";
		echo "</div>";

		//Country
		echo "<div style='margin:10px'>";
		echo "<label for='country' style='font-size:16px'>Country (only delivers to Singapore): </label><br>";
		echo "<input style='width:150%' type='country' id='country' name='country' value='Singapore' readonly='readonly' required enterkeyhint='next'></input>";
		echo "</div>";

		//Address
		echo "<div style='margin:10px'>";
		echo "<label for='street-address' style='font-size:16px'>Street address: </label><br>";
		echo "<input style='width:150%' type='text' id='street-address' name='street-address' value='$tempAddress' autocomplete='street-address' required enterkeyhint='next'></input>";
		echo "</div>";

		//Zipcode
		echo "<div style='margin:10px'>";
		echo "<label for='postal-code' style='font-size:16px'>Postal Code (optional): </label><br>";
		echo "<input style='width:150%' id='postal-code' name='postal-code' enterkeyhint='next'></input>";
		echo "</div>";

		
		echo "</form>";

		echo "<button style='margin:10px' type='enter' form='addressForm' value='enter'>Enter</button>";

		echo "</div>";




		// Add PayPal Checkout button on the shopping cart page
		// echo "<form method='post' action='checkoutProcess.php'>";
		// echo "<input type='image' style='float:right;'
		// 				src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		// echo "</form></p>";

		$conn->close(); // Close database connection
	}




echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
