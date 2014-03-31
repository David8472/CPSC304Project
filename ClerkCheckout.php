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

$result = mysqli_query($con,"SELECT * FROM Borrower
WHERE bid= $bid");

if(mysqli_num_rows($result)>0) {
    echo "User has been found<br>";
    foreach($bookList as $book)
        {
            echo "Checking out book $book <br>";
            if($book != null) {
                $available = mysqli_query($con,"SELECT copyNo
                                          FROM BookCopy
                                          INNER JOIN Book on BookCopy.callNumber = Book.callNumber
                                          WHERE status = 'in'
                                          LIMIT 1");
                if(mysqli_num_rows($available) > 0) {
                  $row = $available->fetch_assoc();
                  $x =  $row["copyNo"];
                  echo "$book copy $x is available<br>";
                }
            } else echo "$book is null<br>";
        }
} else {
    echo "User not found";
}

mysqli_close($con);
?>