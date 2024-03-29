<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$callNumber = $_POST['callNumber'];
$copyNo = $_POST['copyNo'];
$today = date('Y-m-d');

if(!empty($callNumber) and !empty($copyNo)) {
  // Check to see if book has been taken out
  $results=mysqli_query($con,"SELECT *
                        FROM BookCopy
                        WHERE BookCopy.callNumber = $callNumber
                          AND BookCopy.copyNo = $copyNo
                          AND BookCopy.status = 'OUT'");
  if(mysqli_num_rows($results) > 0){
    // Book has been taken out so update information
    $updateBC=mysqli_query($con,"UPDATE BookCopy
                      SET status = 'IN'
                      WHERE callNumber = $callNumber
                       AND copyNo = $copyNo");
    $updateBrrwing=mysqli_query($con,"UPDATE Borrowing
                      SET inDate = '$today'
                      WHERE callNumber = $callNumber
                      AND copyNo = $copyNo");
    echo "Book $callNumber-$copyNo has been checked in.<br>";
    // If the book is overdue add a fine
    $results=mysqli_query($con,"SELECT *
                        FROM Borrowing
                        INNER JOIN Borrower
                          ON Borrowing.bid = Borrower.bid
                        INNER JOIN BorrowerType
                          ON Borrower.type = BorrowerType.type
                        WHERE Borrowing.callNumber = $callNumber
                          AND Borrowing.copyNo = $copyNo;
                        ");
    if ($results){
      $row = mysqli_fetch_array($results);
      $days = intval($row['bookTimeLimit']);
      $outDate = $row['outDate'];
      $dueDate = date("Y-m-d",strtotime("$outDate + $days day"));
      if($dueDate < $today) {
        echo "This book (".$row['callNumber'].
            "-".$row['copyNo'].
            ") is overdue.<br>";
        $bid=$row['bid'];
        $borid=$row['borid'];
        $addFine=mysqli_query($con," INSERT INTO Fine (borid,amount,issuedDate,paidDate)
                              VALUES ('$borid','10','$today','')");
        if ($addFine){
          echo "Add fine to bid:$bid for book $callNumber-$copyNo.<br>";
        } else {
          die ('Error adding fine'.mysqli_error($con));
        }
      }
    } else {
      die('Error: ' . mysqli_error($con));
    }
    // If the book has a hold request, register item on hold
    $results=mysqli_query($con,"SELECT *
                        FROM HoldRequest
                        WHERE callNumber = $callNumber
                        ORDER BY issuedDate
                        LIMIT 1");
    if(mysqli_num_rows($results) > 0){
      $row = $results->fetch_assoc();
      $bid = $row['bid'];
      // Fetch name
      $requester=mysqli_query($con,"SELECT *
                        FROM Borrower
                        WHERE bid = $bid");
      $row = $requester->fetch_assoc();
      $name = $row['name'];
      $email = $row['emailAddress'];
      // Fetch book name
      $requestedBook=mysqli_query($con,"SELECT *
                        FROM Book
                        WHERE callNumber = $callNumber");
      $row = $requestedBook->fetch_assoc();
      $bookname=$row['title'];
      echo "A email has been sent to $name at $email to notify them that 
      the book <i>$bookname</i> ($callNumber) is available.<br>";
      $updateBC=mysqli_query($con,"UPDATE BookCopy
                      SET status = 'ON-HOLD'
                      WHERE callNumber = $callNumber
                       AND copyNo = $copyNo");
    }
   
  } else {
    echo "Book $callNumber-$copyNo has not been taken out.<br>";
  }
}
if(empty($callNumber)) {
  echo "Please enter call number.<br>";
}
if(empty($copyNo)) {
  echo "Please enter copy no.";
}
mysqli_close($con);
?>