<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"UPDATE BookCopy SET status='in' ");
mysqli_query($con,"DELETE FROM Borrowing");
mysqli_close($con);
?>