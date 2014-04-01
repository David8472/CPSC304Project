<?php

$con=mysqli_connect("localhost","root","","DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
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

// Borrower
mysqli_query($con,"INSERT INTO Borrower(password,name,address,phone,emailAddress,sinOrStNo,expiryDate,type)
             VALUES('123','Bob','1234 E','604','happy@gmail.com','12345','2015-12-01','Student')");

mysqli_query($con,"INSERT INTO Borrower (password, name, address, phone, emailAddress, sinOrStNo, expiryDate, type)
             VALUES ('321', 'Carl', '4321 E', '406','sad@gmail.com','654321','2015-05-11','Staff')");

mysqli_query($con,"INSERT INTO Borrower (password, name, address, phone, emailAddress, sinOrStNo, expiryDate, type)
             VALUES ('333', 'Ed', '4333 E', '333','yolo@gmail.com','33333','2013-05-11','Faculty')");
             
// BorrowerType
mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Student','14')");

mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Faculty','84')");

mysqli_query($con,"INSERT INTO BorrowerType (type, bookTimeLimit)
             VALUES ('Staff','42')");

// Books
mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1111','B0001','Hello','C.K','BookCo.',2012)");

mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1112','B0001','Hello World','C.K','BookCo.',2013)");

mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1123','C0001','Hello Cat','J.K Rowling','BookCo.',2011)");

mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
             VALUES ('1121','C0001','Hello Dog','Tony Stark','BookCo.',2011)");

// HasAuthors
mysqli_query($con,"INSERT INTO HasAuthor(callNumber,name)
             VALUES ('1111','C.K, D.E, F.A')");
mysqli_query($con,"INSERT INTO HasAuthor(callNumber,name)
             VALUES ('1112','C.K, D.E')");
mysqli_query($con,"INSERT INTO HasAuthor(callNumber,name)
             VALUES ('1123','J.K Rowling')");
mysqli_query($con,"INSERT INTO HasAuthor(callNumber,name)
             VALUES ('1121','Tony Stark, Peter Parker')");

// HasSubject
mysqli_query($con,"INSERT INTO HasSubject(callNumber,subject)
             VALUES ('1111','COMPUTER SCIENCE')");
mysqli_query($con,"INSERT INTO HasSubject(callNumber,subject)
             VALUES ('1112','ADV COMPUTER SCIENCE')");
mysqli_query($con,"INSERT INTO HasSubject(callNumber,subject)
             VALUES ('1123','PET CATS')");
mysqli_query($con,"INSERT INTO HasSubject(callNumber,subject)
             VALUES ('1121','PET DOGS')");

// Book Copies
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('1','1123','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('1','1121','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('1','1111','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('2','1111','OUT')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('3','1111','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('1','1112','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('2','1112','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('3','1112','OUT')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('4','1112','IN')");
mysqli_query($con,"INSERT INTO BookCopy (copyNo, callNumber, status)
             VALUES ('5','1112','IN')");

// HoldRequests
mysqli_query($con,"INSERT INTO HoldRequest (bid,callNumber,issuedDate)
             VALUES('2','1111','2013-03-03')");
mysqli_query($con,"INSERT INTO HoldRequest (bid,callNumber,issuedDate)
             VALUES('3','1111','2013-02-03')");

// Borrowing             
mysqli_query($con,"INSERT INTO Borrowing (bid,callNumber,copyNo,outDate,inDate)
             VALUES('1','1111','2','2013-03-02','0-0-0')");
mysqli_query($con,"INSERT INTO Borrowing (bid,callNumber,copyNo,outDate,inDate)
             VALUES('1','1112','3','2013-02-02','0-0-0')");


mysqli_close($con);


echo "Dummy values inserted";
?>