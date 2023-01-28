<?php
session_start();

include("header.php");
?>

<?php

$shopperID = $_SESSION["ShopperID"];
$subject = $_POST["subject"];
$content = $_POST["content"];
$rank = $_POST["rank"];

include_once("mysql_conn.php");

$qry = "INSERT INTO Feedback (ShopperID,Subject,Content,Rank)
 VALUES (?,?,?,?)";

$stmt = $conn->prepare($qry);

$stmt->bind_param("ssss",$shopperID,$subject,$content,$rank);

$stmt->execute();

$stmt->close();

$conn->close();

?>

<?php
echo "<h1>Adding feedback to database.......</h1>";
?>

<script type="text/javascript">

setTimeout(function () {
  window.location.href= 'feedbackForum.php'; // the redirect goes here
},5000);        

</script>

<div class="product-slider">
  <div id="carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="item active"> <img src="Images/Slider_Index/1.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/2.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/3.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/4.png"> </div>
      <div class="item"> <img src="Images/Slider_Index/5.png"> </div>
      <!-- <div class="item"> <img src="http://placehold.it/1600x700?text=Product+06"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+07"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+08"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+09"> </div>
      <div class="item"> <img src="http://placehold.it/1600x700?text=Product+10"> </div> -->
    </div>
  </div>
</div>

<?php
include("footer.php");
?>