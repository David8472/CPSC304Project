<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}

//$bid = $_POST'['bid'];
$bid = "1";
//$bookList = array($_POST'['callNumber'],$_POST'['callNumber'],$_POST'['callNumber'],$_POST'['callNumber']);
$bookList = array("1111","1121","1123","1113","");
$numOfBooks = count($bookList);
$stack=array();
$today = date('m-d-Y');
$result = mysqli_query($con,"SELECT * FROM Borrower
                       WHERE bid = $bid");
 
if(mysqli_num_rows($result)>0) {
    echo "User has been found<br>";
    $row = mysqli_fetch_array($result);
    if($row['expiryDate'] < $today){
      echo "Card has expired<br>";
    } else {
      foreach($bookList as $book)
        {
            if($book != null) {
                $available = mysqli_query($con,"SELECT copyNo
                                          FROM BookCopy
                                          INNER JOIN Book on BookCopy.callNumber = $book
                                          WHERE status = 'in'
                                          LIMIT 1");
                if(mysqli_num_rows($available) > 0) {
                  $row = $available->fetch_assoc();
                  $copyNo =  $row["copyNo"];
                  echo "$book copy $copyNo is available<br>";
                  mysqli_query($con,"UPDATE BookCopy
                               SET status ='out'
                               WHERE callNumber = $book
                                AND copyNo = $copyNo");
                  $outDate=date("Y-m-d");
                  $dueDate=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+14,date("Y")));
                  $sql="INSERT INTO Borrowing
                  (bid, callNumber, copyNo, outDate, inDate)
                  VALUES
                  ($bid,$book,$copyNo,'$outDate','$dueDate')";
                  
                  // Check for errors
                  if (!mysqli_query($con,$sql))
                    {
                      die('Error: ' . mysqli_error($con));
                    }
                  array_push($stack,array("$book","$copyNo","$dueDate"));
                } else echo "$book is not available<br>";
            }
        }
        // Method 1 Selects all items from this submission
        for($x=0;$x<count($stack);$x++){
          echo "Book ".$stack[$x][0].
            " Copy ".$stack[$x][1].
            " Due ".$stack[$x][2];
            echo "<br>";
        }
        // Method 2 Selects all items related to that bid
        $results = mysqli_query($con,"SELECT *
                                  FROM Borrowing
                                  WHERE bid = $bid
                                  ORDER BY outDate");
        echo "===Reciept for Borrower====<br>";
        while($row = mysqli_fetch_array($results))
          {
            echo "Book ".$row['callNumber'].
            " Copy ".$row['copyNo'].
            " Due ".$row['outDate'];
            echo "<br>";
          }
    }
} else {
    echo "User not found";
}

mysqli_close($con);
?>