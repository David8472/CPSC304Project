<?php

$con=mysqli_connect("localhost","root","","DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql="DELETE FROM Borrower";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }
$sql="DELETE FROM BorrowerType";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }
$sql="DELETE FROM BookCopy";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }
$sql="DELETE FROM Book";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }
$sql="DELETE FROM Borrowing";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }

//Borrower
mysqli_query($con,"INSERT INTO Borrower(password,name,address,phone,emailAddress,sinOrStNo,expiryDate,type)
             VALUES('123','Bob','1234 E','604','happy@gmail.com','12345','2015-12-01','Student')");

mysqli_query($con,"INSERT INTO Borrower (password, name, address, phone, emailAddress, sinOrStNo, expiryDate, type)
             VALUES ('321', 'Carl', '4321 E', '406','sad@gmail.com','654321','2015-05-11','Faculty')");

mysqli_query($con,"INSERT INTO Borrower (password, name, address, phone, emailAddress, sinOrStNo, expiryDate, type)
             VALUES ('333', 'Ed', '4333 E', '333','yolo@gmail.com','33333','2013-05-11','Faculty')");
             
// BorrowerType
mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Student','14')");

mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Faculty','84')");

mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Staff','42')");

//Books
mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1111','B0001','Hello','C.K','BookCo.',2012)");

mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1112','B0001','Hello World','C.K','BookCo.',2013)");

mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1111','in')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1111','out')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1111','on-hold')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1112','in')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1112','in')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1112','out')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1112','out')");
mysqli_query($con,"INSERT INTO BookCopy (callNumber, status)
             VALUES ('1112','on-hold')");

//mysqli_query($con,"INSERT INTO Borrowing (bid,callNumber,copyNo,outDate,inDate)
             //VALUES('1','1111','2','2013-2-2','0-0-0')");
//mysqli_query($con,"INSERT INTO Borrowing (bid,callNumber,copyNo,outDate,inDate)
             //VALUES('1','1112','2','2013-2-2','0-0-0')");
//mysqli_query($con,"INSERT INTO Borrowing (bid,callNumber,copyNo,outDate,inDate)
             //VALUES('1','1112','3','2012-2-4','0-0-0')");

mysqli_query($con,"INSERT INTO HoldRequest (bid,callNumber,issuedDate)
             VALUES('2','1111','2013-03-03')");
mysqli_query($con,"INSERT INTO HoldRequest (bid,callNumber,issuedDate)
             VALUES('3','1111','2013-02-03')");

mysqli_close($con);
?>