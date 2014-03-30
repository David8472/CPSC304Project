<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}
  
//  mysqli_query($con,"INSERT INTO Borrower (bid, password, name, address, phone, emailAddress, sinOrStNo, expiryDate, type) Values ()");

$sql="INSERT INTO Borrower
(password,
name,
address,
phone,
emailAddress,
sinOrStNo,
expiryDate,
type)"
VALUES
('$_POST[password]',
'$_POST[name]',
'$_POST[address]',
'$_POST[emailAddress]',
'$_POST[sinOrStNo]',
'$_POST[expiryDate]',
'$_POST[type]')

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
echo "Borrower added";

mysqli_close($con);
?>