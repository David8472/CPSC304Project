<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$today = date('m-d-Y');
$results=mysqli_query($con,"SELECT *
                      FROM Borrowing
                      INNER JOIN Borrower
                        ON Borrowing.bid = Borrower.bid
                      INNER JOIN BorrowerType
                        ON Borrower.type = BorrowerType.type"
                      );
// Check for errors
if (!$results){
  die('Error: ' . mysqli_error($con));
} else {
  while($row = mysqli_fetch_array($results)) {
    if($row['type'] == 'Student'){
      $days = intval($row['bookTimeLimit']);
      $outDate = $row['outDate'];
      $dueDate = date("m-d-Y",strtotime("$outDate + $days day"));
      if($dueDate < $today) {
        echo "Bid (".$row['bid'].
        ") Email (".$row['emailAddress'].
        ") callNumber (".$row['callNumber'].
        ") Taken Out (".$row['outDate'].
        ") Due (".$dueDate;
        echo ")<br>";
      }
    }
  }
}
          
if (!isset($_POST["submit"]))
  {
  ?>
  <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
  From: <input type="text" name="from"><br>
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
    $from = $_POST["from"]; // sender
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    // message lines should not exceed 70 characters (PHP rule), so wrap it
    $message = wordwrap($message, 70);
    // send mail
    mail("webmaster@example.com",$subject,$message,"From: $from\n");
    echo "Thank you for sending us feedback";
    }
  }
mysqli_close($con);
?>