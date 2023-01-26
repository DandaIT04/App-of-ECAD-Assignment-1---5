<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a container, 90% width of viewport -->
<div style='width:90%; margin:auto;'>

<?php 
$pid=$_GET["pid"]; // Read Product ID from query string

// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php"); 
$qry = "SELECT * from product where ProductID=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $pid); 	// "i" - integer 
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// To Do 1:  Display Product information. Starting ....
while ($row = $result->fetch_array()){
    // Display Page Header -
    // Product's name is read from the "ProductTitle" column of "product" table.
    echo "<div class='row'";
    echo "<div class='col-sm-12' style='padding:5px'>";
    echo "<span class='page-title'>$row[ProductTitle]</span>";
    if ($row["Offered"] == 1){
		echo "<span class='page-title font-weight-bolder px-4' style='color: red;'>&lt;On Offer&gt;</span>";
	}
    echo "</div>";
    echo "</div>";

    echo "<div class='row'>"; //Start a new row

    //Left column - display the product's description,
    echo "<div class='col-sm-9' style='padding: 15px;'>";
    echo "<p class='py-4'>$row[ProductDesc]</p>";

    //Left column - display the product
    $qry = "SELECT s.SpecName, ps.SpecVal from productspec ps
            INNER JOIN specification s ON ps.SpecID=s.SpecID
            WHERE ps.ProductID=?
            ORDER BY ps.priority";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i", $pid); //"i" = integer
    $stmt->execute();
    $result2 = $stmt->get_result();
    $stmt->close();
    while($row2=$result2->fetch_array()){
        echo "<div class='py-2'>";
        echo $row2["SpecName"].": ".$row2["SpecVal"]."<br />";
        echo "</div>";
    }
    echo "</div>"; // End of left column

    //Right column - display the product's image
    $img = "./Images/products/$row[ProductImage]";
    echo "<div class='col-sm-3' style='vertical-align:top; padding:5px'>";
    echo "<p><img src=$img /></p>";

    //Right column - display the product's price
    $formattedPrice = number_format($row["Price"], 2);
    
    if ($row["OfferedPrice"] != NULL){
        echo "Price:<span style='font-weight:bold; color:red;'>
        <s>S$ $formattedPrice</s></span>";
        $formattedPrice2 = number_format($row["OfferedPrice"], 2);
        echo "<span style='font-weight: bold; color: red; font-size: 1.2vw'>
        S$ $formattedPrice2</span>";
    }
    else{
        echo "Price:<span style='font-weight:bold; color:red;'>
        S$ $formattedPrice</span>";
    }

    // Assignment disabled button
    if ($row["Quantity"] <= 0){
        echo "<form action='cartFunction.php' method='post'>";
        echo "<input type='hidden' name='action' value='add' />";
        echo "<input type='hidden' name='product_id' value=$pid />";
        echo "Quantity: <input type='number' disabled='disabled' name='quantity' value='1'
                        min='1' max='10' style='width:40px;' required />";
        echo "<button type='submit' disabled='disabled' style='color:grey;'>Add to Cart</button>";
        echo "</form>";
        echo "<span style='font-weight: 700; color: red; font-size: 1.4vw'>OUT OF STOCK</span>";
        echo "</div>"; //End of right column
        echo "</div>"; //End of row
    }
    else{
        // To Do 2:  Create a Form for adding the product to shopping cart. Starting ....
        echo "<form action='cartFunction.php' method='post'>";
        echo "<input type='hidden' name='action' value='add' />";
        echo "<input type='hidden' name='product_id' value=$pid />";
        echo "Quantity: <input type='number' name='quantity' value='1'
                        min='1' max='10' style='width:40px' required />";
        echo "<button type='submit'>Add to Cart</button>";
        echo "</form>";
        echo "</div>"; //End of right column
        echo "</div>"; //End of row
        // To Do 2:  Ending ....
    }
}

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
