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

echo "<div id='myShopCart' style='margin:auto'>"; // Start a container
if (isset($_SESSION["Cart"])) {
	include_once("mysql_conn.php");
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT *, (Price*Quantity) AS Total
			FROM ShopCartItem WHERE ShopCartID=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]); // "i" - integer
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// To Do 2 (Practical 4): Format and display 
		// the page header and header row of shopping cart page
		echo "<p class='page-title' style='text-align:center'>Shopping Cart</p>"; 
		echo "<div class='table-responsive' >"; // Bootstrap responsive table
		echo "<table class='table table-hover'>"; // Start of table
		echo "<thead class='cart-header'>"; //Start of table's header section
		echo "<tr>"; //Start of header row
		echo "<th width='250px'>Item</th>";
		echo "<th width='90px'> Price (S$)</th>";
		echo "<th width='60px'>Quantity</th>";
		echo "<th width='120px'>Total (S$)</th>";
		echo "<th>&nbsp;</th>";
		echo "<th width='200px'>Update</th>";
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
			echo "Product ID: $row[ProductID]</td>";
			$formattedPrice = number_format($row["Price"], 2);
			echo "<td>$formattedPrice</td>";
			echo "<td>$row[Quantity]</td>";

			$formattedTotal = number_format($row["Total"], 2);
			echo "<td>$formattedTotal</td>";

			echo "<td>"; // Column for remove item from shopping cart
			echo "<form action='cartFunction.php' method='post'>";
			echo "<input type='hidden' name='action' value='remove' />";
			echo "<input type='hidden' name='product_id' value='$row[ProductID]' />";
			echo "<input type='image' src='images/trash-can.png' title='Remove Item'/>";
			echo "</form>";
			echo "</td>";

			echo "<td>"; //Column for update quantity of purchase
			echo "<form action='cartFunction.php' method='post'>";
			echo "<input type='hidden' name='action' value='update' />";
			echo "<input type='hidden' name='product_id' value='$row[ProductID]' />";
			echo "Quantity: <input type='number' name='quantity' value='1'
								min='1' max='10' style='width:40px' required />";
			echo "&nbsp;";
			echo "<button type='submit'> Update </button>";
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
		// Additional Requirment 2
		// Total Quantity in Cart
		echo "<p style='text-align:right; font-size:15px'>
			  Total Quantity is ". number_format($subTotalQuantity);
		$_SESSION["SubTotalQ"] = round($subTotalQuantity);	
		echo "<br>";
		echo "<br>";
		// Additional Requirment
		// Delivery Chargings
		if ($_SESSION["SubTotal"] > 200) {
			echo "<br>";
			echo "<p style='text-align:right; font-size:15px; color:red;' > Delivery Charges are waived for orders above $200";
		}
		else {
			echo "<p style='text-align:right; font-size:15px'> Please Select Delivery Mode";
			echo "<br>";
			echo "<form style='text-align:right;' action='' method='post'>";
			echo "<label>";
			echo "<input method='post' type='radio' name='deliverType' value='standard'> Standard Delivery (S$5.00)";
			echo "</label>";
			echo "<br>";
			echo "<label>";
			echo "<input type='radio' name='deliverType' value='express'> Express Delivery (S$10.00)";
			echo "</label>";
			echo "<br>";
			echo "<input type='submit' value='Update Delivery Type'>";
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
			// Basic Requirment
			// Display the subtotal at the end of the shopping cart
			else{
				echo "<p style='text-align:right; font-size:20px'>
			  	Subtotal = S$". number_format($subTotal, 2);
			}	
		}
		echo "<br>";
		echo "<br>";

		// // Display the subtotal at the end of the shopping cart
		// echo "<p style='text-align:right; font-size:20px'>
		// 	  Subtotal = S$". number_format($subTotal, 2);
		// $_SESSION["SubTotal"] = round($subTotal, 2);

		// echo "<p>Content in items session variable:<br />";
		// Foreach($_SESSION['Items'] as $key1=>$item){
		// 	echo "items[". $key1 . "] : ";
		// 	foreach($item as $key2=>$value2){
		// 		echo $key2 . "=> " . $value2 . ", ";
		// 	}
		// 	echo "<br />";
		// }
		// echo "</p>";
		
		// Add PayPal Checkout button on the shopping cart page
		// echo "<form method='post' action='checkoutProcess.php'>";
		// echo "<input type='image' style='float:right;'
		// 				src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		// echo "</form></p>";

		echo "<form method='post' action='checkoutConfirmation.php'>
				<input type='submit' class='checkout'
				name='checkout-btn' id='checkout-btn'
				value='Checkout'/>
	  			</form>";
	}
	else {
		echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
	}
	$conn->close(); // Close database connection
}
else {
	echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
