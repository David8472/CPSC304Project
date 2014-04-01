<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}
$name=$_POST['name'];
$pass=$_POST['password'];
$add=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['emailAddress'];
$sinOrStNo=$_POST['sinOrStNo'];
$expiryDate=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+5));
$type=$_POST['type'];
if($type == 'Student' or $type == 'Faculty' or $type =='Staff'){
  if(!empty($pass) AND !empty($name) AND !empty($sinOrStNo) AND !empty($type) ) {
    $sql="INSERT INTO Borrower
    (password,
    name,
    address,
    phone,
    emailAddress,
    sinOrStNo,
    expiryDate,
    type)
    VALUES
    ('$pass',
    '$name',
    '$add',
    '$phone',
    '$email',
    '$sinOrStNo',
    '$expiryDate',
    '$type')";
    
    if (!mysqli_query($con,$sql))
      {
      die('Error: ' . mysqli_error($con));
      }
    echo "Borrower added";
  }
} else echo"Please enter valid type.<br>";

if (empty($pass)){
  echo"Please enter password.<br>";
}
if (empty($name)){
  echo"Please enter name.<br>";
}
if (empty($sinOrStNo)){
  echo"Please enter SIN or student number.<br>";
}
if (empty($type)){
  echo"Please enter type.<br>";
}
mysqli_close($con);
?>