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

<?php
include("promotion.php");
include("footer.php");
?>