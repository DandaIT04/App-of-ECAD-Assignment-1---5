<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a container, 60% width of viewport -->
<div style='width:70%; margin:auto;'>
<!-- Display Page Header - Category's name is read 
     from the query string passed from previous page -->
<div class="row" style="padding:5px">
	<div class="col-12 text-center">
		<span class="page-title"><?php echo "$_GET[catName]"; ?></span>
	</div>
</div>

<?php 
// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
$cid=$_GET["cid"]; //Read Category ID from query string
// Form SQL to retrieve list of products associated to the Category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity, p.OfferedPrice, p.Offered
		FROM CatProduct cp INNER JOIN product p ON cp.ProductID=p.ProductID
		WHERE cp.CategoryID=?
		ORDER BY ProductTitle";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $cid); //"i" - integer
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

//Display each product in a row
while ($row = $result->fetch_array()){
	echo "<div class='row' style='padding:10px'>"; //Start a new row

	//Left column - display a text link showing the product's name,
	//				display the selling price in red in a new paragraph
	$product = "productDetails.php?pid=$row[ProductID]";
	$formattedPrice = number_format($row["Price"],2);
	echo "<div class='col-8'>"; //67% of row width
	echo "<p class='h4 font-weight-bolder'><a href=$product>$row[ProductTitle]</a></p>";
	if ($row["OfferedPrice"] != NULL){
		$formattedPrice2 = number_format($row["OfferedPrice"],2);
		echo "Price:<span style='font-weight: bold; color: red;'>
		<s>S$ $formattedPrice</s></span>";
		echo "<span style='font-weight: bold; color: red; font-size: 1.2vw'>
        S$ $formattedPrice2</span>";
		
	}
	else{
		echo "Price:<span style='font-weight: bold; color: red;'>
		S$ $formattedPrice</span>";
	}
	if ($row["Offered"] == 1){
		echo "<p class='h3 font-weight-bolder' style='color: red;'>&lt;On Offer&gt;</p>";
	}
	echo "</div>";

	//Right column - display the product's image
	$img = "./Images/products/$row[ProductImage]";
	echo "<div class='col-4'>"; //33% of row width
	echo "<img src='$img' width='250vw' height='250vw'/>";
	echo "</div>";

	echo "</div>"; //End of a row
}
// To Do:  Ending ....

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
