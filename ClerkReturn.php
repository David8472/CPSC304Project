<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}
$callNumber = '$_POST[callNumber]';

$sql="UPDATE BookCopy "
mysqli_close($con);
?>