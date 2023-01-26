﻿<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a container, 60% width of viewport -->
<div style="width:70%; margin:auto;">
<!-- Display Page Header -->
<div class="row" style="padding:5px"> <!-- Start of header row -->
    <div class="col-12 text-center">
        <span class="page-title">Product Categories</span>
        <p>Select a category listed below:</p>
    </div>
</div> <!-- End of header row -->

<?php 
// Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// To Do:  Starting ....
$qry = "SELECT * FROM Category ORDER BY CatName";
$result = $conn->query($qry);

//Display each category in a row
while ($row = $result->fetch_array()){
    echo "<div class='row' style='padding:10px'>"; // Start a new row

    //Left column - display a text link showing the category's name,
    //              display category's description in a new paragraph
    $catname = urlencode($row["CatName"]);
    $catproduct = "catProduct.php?cid=$row[CategoryID]&catName=$catname";
    echo "<div class='col-8'>"; //67% of row width
    echo "<p class='h4 font-weight-bolder'><a href=$catproduct>$row[CatName]</a></p>";
    echo "$row[CatDesc]";
    echo "</div>";

    //Right column - display the category's image
    $img = "./Images/category/$row[CatImage]";
    echo "<div class='col-4'>"; //33% of row width
    echo "<img src='$img'/>";
    echo "</div>";

    echo "</div>"; //End of a row
}
// To Do:  Ending ....

$conn->close(); // Close database connnection
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>
