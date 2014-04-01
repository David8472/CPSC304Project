<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$today = date('Y-m-d');
$results=mysqli_query($con,"SELECT *
                      FROM Borrowing
                      INNER JOIN Borrower
                        ON Borrowing.bid = Borrower.bid
                      INNER JOIN BorrowerType
                        ON Borrower.type = BorrowerType.type");
// Check for errors
if (!$results){
  die('Error: ' . mysqli_error($con));
} else {
  // table header
  echo "<table border='1'>
      <tr>
      <th>bid</th>
      <th>Name</th>
      <th>Email</th>
      <th>Catalogue No</th>
      <th>Checkout Date</th>
      <th>Due Date</th>
      </tr>";
  while($row = mysqli_fetch_array($results)) {
    if($row['inDate'] == '0000-00-00'){
      $days = intval($row['bookTimeLimit']);
      $outDate = $row['outDate'];
      $dueDate = date("Y-m-d",strtotime("$outDate + $days day"));
      //table items
      if($dueDate < $today) {
        echo "<tr>";
        echo "<td>".$row['bid']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['emailAddress']."</td>";
        echo "<td>".$row['callNumber']."-".$row['copyNo']."</td>";
        echo "<td>".$row['outDate']."</td>";
        echo "<td>".$dueDate."</td>";
        echo "</tr>";
      }
    }
  }
  echo "</table>";
}
          
if (!isset($_POST["submit"]))
  {
  ?>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
  To: <input type="text" name="to"><br>
  Subject: <input type="text" name="subject"><br>
  Message:<br> <textarea rows="10" cols="40" name="message"></textarea><br>
  <input type="submit" name="submit" value="Submit Feedback">
  </form>
  <?php 
  }
else
  // the user has submitted the form
  {
  // Check if the "from" input field is filled out
  if (isset($_POST["from"]))
    {
    $to = $_POST["to"]; // sender
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail("webmaster@example.com",$subject,$message,"From: $to\n");
    echo "Please return your books! Thanks";
    }
  }
mysqli_close($con);
?>