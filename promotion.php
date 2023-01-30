<?php
     // Include the PHP file that establishes database connection handle: $conn
include_once("mysql_conn.php");

// Form SQL to retrieve list of products on offer
$datestring = date("Y-m-d", time());
$qry = "SELECT ProductID, ProductTitle, ProductDesc, ProductImage, Price, Quantity, OfferedPrice, OfferStartDate, OfferEndDate
		FROM product
		WHERE Offered = 1 AND OfferStartDate <= '$datestring' AND OfferEndDate >= '$datestring'";
$stmt = $conn->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="product-slider">
  <div id="carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        $active = 0;
        while ($row = $result->fetch_array()){ 
            if ($active == 0){
        ?>
                <div class="item active" style="background-image:url('Images/promotion_bg.jpg');"> 
                <?php
                    //Left column - display the category's image
                    echo "<div class='row' style='padding:10px'>";
                    $img = "./Images/products/$row[ProductImage]";
                    echo "<div class='col-4'>"; //33% of row width
                    echo "<img src='$img'/>";
                    echo "</div>";
                    $formattedPrice = number_format($row["Price"],2);
                    $formattedPrice2 = number_format($row["OfferedPrice"],2);
                    echo "<div class='col-8' style='text-align:center;'>"; //67% of row width

                    echo "<p class='h3 font-weight-bolder'><a href='productDetails.php?pid=$row[ProductID]'><u>$row[ProductTitle]</u></a></p>";
                    echo "<p class='py-4' style='font-size: 1.1vw'>$row[ProductDesc]</p>";
                    echo "Price:<span style='color: red;'>
                        <s>S$ $formattedPrice</s></span>";
                    echo "<span style='font-weight: bold; color: red; font-size: 1.2vw'>
                        S$ $formattedPrice2</span>";

                    echo "</div>";
                    echo "</div>";
                ?>
                </div>
        <?php
            $active = 1;
            }
            else{
        ?>       
                <div class="item" style="background-image:url('Images/promotion_bg.jpg');"> 
                <?php
                    //Left column - display the category's image
                    echo "<div class='row' style='padding:10px'>";
                    $img = "./Images/products/$row[ProductImage]";
                    echo "<div class='col-4'>"; //33% of row width
                    echo "<img src='$img'/>";
                    echo "</div>";
                    $formattedPrice = number_format($row["Price"],2);
                    $formattedPrice2 = number_format($row["OfferedPrice"],2);
                    echo "<div class='col-8' style='text-align:center;'>"; //67% of row width

                    echo "<p class='h3 font-weight-bolder'><a href='productDetails.php?pid=$row[ProductID]'><u>$row[ProductTitle]</u></a></p>";
                    echo "<p class='py-4' style='font-size: 1.1vw'>$row[ProductDesc]</p>";
                    echo "Price:<span style='color: red;'>
                        <s>S$ $formattedPrice</s></span>";
                    echo "<span style='font-weight: bold; color: red; font-size: 1.2vw'>
                        S$ $formattedPrice2</span>";

                    echo "</div>";
                    echo "</div>";
                ?>
                </div>
        <?php        
            }
        }
        ?>
    </div>
  </div>
</div>