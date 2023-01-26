<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- HTML Form to collect search keyword and submit it to the same page in server -->
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <div class="form-group row"> <!-- 1st row -->
        <div class="col-sm-9 offset-sm-1 text-center">
            <span class="page-title">Product Search</span>
        </div>
    </div> <!-- End of 1st row -->
    <div class="form-group row"> <!-- 2nd row -->
        <label for="keywords" 
               class="col-sm-3 col-form-label">Product Title:</label>
        <div class="col-sm-6 searchbar">
            <input class="form-control" name="keywords" id="keywords" 
                   type="search" placeholder="Search..."/>

        </div>
        <div class="col-sm-3">
            <button type="submit">Search</button>
        </div>
    </div>  <!-- End of 2nd row -->
</form>

<?php
// The non-empty search keyword is sent to server
if (isset($_GET["keywords"]) && trim($_GET['keywords']) != "") {
    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
	// contains the keyword entered by shopper, and display them in a table.
	echo "<p /><table>";
    echo "<tr><th> Search results for $_GET[keywords]:</th></tr>";
    $SearchText ="%".$_GET["keywords"]."%"; // % - wildcard in search string
    // Include the PHP file that establishes database connection handle: $conn
    include_once("mysql_conn.php");
    // Form SQL to select the product record with "Product Title" or 
    //- "Product Description" contains the search keyword
    $qry = "SELECT ProductID, ProductTitle, ProductImage, Price, Quantity
            FROM product WHERE ProductTitle LIKE ? OR ProductDesc LIKE ?
            ORDER BY ProductTitle ASC";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("ss", $SearchText, $SearchText);
    $stmt->execute(); //Execute prepared SQL statement
    $result= $stmt->get_result(); //Get the exception result
    $stmt->close();
    $conn->close(); // Close database connection

    if ($result->num_rows > 0){ //Matching records found
        while ($row = $result->fetch_array()){
            // Display a text link to product details page,
            // hyperlink displays the product title
            $product = "productDetails.php?pid=$row[ProductID]";
            echo "<tr><td style='padding: 4px;'>
            <a href=$product>$row[ProductTitle]</a></td></tr>";

        }
    }
    else { //No matching record
        echo "<tr><td>";
        echo "<h3 style='color:red'> No record found</h3>";
        echo "</td></tr>";
    }
    echo "</table>";

	// To Do (DIY): End of Code
}

echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>

<style>
#keywords {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  margin-bottom: 12px; /* Add some space below the input */
  width: 90%;
  background-repeat: no-repeat;
  background-size: 18px 18px;
  background-position: 95% center;
  border-radius: 50px;
  border: 1px solid #575756;
  transition: all 250ms ease-in-out;
  backface-visibility: hidden;
  transform-style: preserve-3d;
}

#keywords::placeholder{
    color: color(#575756 a(0.8));
    letter-spacing: 1.5px;
}

#keywords:hover{
    padding: 12px 0;
    outline: 0;
    border: 1px solid transparent;
    border-bottom: 1px solid #575756;
    border-radius: 0;
    background-position: 100% center;
}

#keywords:focus{
    padding: 12px 0;
    outline: 0;
    border: 1px solid transparent;
    border-bottom: 1px solid #575756;
    border-radius: 0;
    background-position: 100% center;
}

.searchbar{
    display:flex;
    margin-top: 50;
    justify-content: left;
}

</style>

<script>
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("keywords");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByClassName("title")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>
