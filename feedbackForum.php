<?php 
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php");

$forumContent1 = "";
?>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;  
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
  padding: 8px;  
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>

<script type="text/javascript">

function validateForm()
{
  if (document.feedbackForum.subject.value.length < 4) {
    alert("subject must be at least 4 characters!");
    return false;              // cancel submission    
  }

  if (document.feedbackForum.subject.value.length > 254){
    alert("subject max characters capped at 254!");
    return false;     
  }

  if (document.feedbackForum.content.value.length < 3) {
    alert("content must be at least 3 characters!");
    return false;              // cancel submission    
  }

  if (document.feedbackForum.content.value.length > 19999){
    alert("content exceeded 20000 characters!");
    return false;     
  }
  
  if (document.feedbackForum.rank.value < 1){
    alert("Invalid rank value!");
    return false;
  }

  if (document.feedbackForum.rank.value > 5){
    alert("Invalid rank value!");
    return false;
  }

  return true;  // No error found
}

</script>

<h1>Feedback Forum</h1>

<div style="overflow-x:auto;">
<table id="customers">
  <tr>
    <th hidden>ShopperID</th>
    <th>Subject</th>
    <th>Content</th>
    <th>Rank</th>
    <th>Date Created</th>
  </tr>

<?php

include_once("mysql_conn.php");

$tempQryCheck = "SELECT * FROM Feedback";

$tempCheck = $conn->prepare($tempQryCheck);

$tempCheck -> execute();

$tempResult = $tempCheck->get_result();
$tempCheck-> close();

if ($tempResult -> num_rows > 0){
  foreach ($tempResult as $theRow){
    echo"<tr>";
    echo"<td hidden>$theRow[ShopperID]</td>";
    echo"<td>$theRow[Subject]</td>";
    echo"<td>$theRow[Content]</td>";
    echo"<td>$theRow[Rank]</td>";
    echo"<td>$theRow[DateTimeCreated]</td>";
    echo"</tr>";
  }
    
}

if(isset($_SESSION["ShopperName"])) {
  $forumContent1 = "<form name='feedbackForum' action='createFeedback.php' method='post' onsubmit='return validateForm(this)'>
  <div class='container'>
    <br><br><br>
    <h1>Add Feedback</h1>
    <hr>  

    <label for='subject'><b>Subject</b></label>
    <input class='form-control' type='text' placeholder='Enter Subject' name='subject' id='subject' required>

    <label for='content'><b>Content</b></label>
    <input class='form-control' type='text' placeholder='Enter Content' name='content' id='content' required>  

    <label for='rank'><b>Rank</b></label>
    <input class='form-control' type='number' placeholder='Enter Rank' name='rank' id='rank' min='1' max='5' required>  

    <br>
    <hr>
    <button type='submit' class='registerbtn'>Submit Feedback</button>
  </div>
</form>";
}

?>
  
</table>
</div>

<?php echo $forumContent1; ?>

<?php
include("promotion.php");
include("footer.php");
?>