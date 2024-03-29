<?php



$con=mysqli_connect("localhost","root","");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql="DROP DATABASE IF EXISTS DBCPSC304";
if (!mysqli_query($con,$sql))
  {
    die('Error: ' . mysqli_error($con));
  }
// Create database
$sql="CREATE DATABASE DBCPSC304";
if (mysqli_query($con,$sql)){
  echo "DBCPSC304 database created successfully";
}
else{
  echo "Error creating database: " . mysqli_error($con);
}

mysqli_close($con);


// Connect to the database and then make all the tables


$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
}

//Make Borrower Table
$sql = "CREATE TABLE Borrower
(
bid INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(bid),
password CHAR(16),
name CHAR(50),
address CHAR(50),
phone  CHAR(16),
emailAddress CHAR(50),
sinOrStNO CHAR(16),
expiryDate DATE,
type CHAR(8)
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />Borrower table created successfully";
}
else{
  echo "<br />Error creating Borrower table: " . mysqli_error($con);
}
  
  
//Make BorrowerType table
$sql = "CREATE TABLE BorrowerType
(
type CHAR(8) NOT NULL, 
PRIMARY KEY(type),
bookTimeLimit CHAR(10)
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />BorrowerType table created successfully";
}
else{
  echo "<br />Error creating BT table: " . mysqli_error($con);
}



//Make Book table
$sql = "CREATE TABLE Book
(
callNumber CHAR(50) NOT NULL, 
PRIMARY KEY(callNumber),
isbn CHAR(17),
title CHAR(50),
mainAuthor CHAR(50),
publisher CHAR(50),
year INT
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />Book table created successfully";
}
else{
  echo "<br />Error creating Book table: " . mysqli_error($con);
}



//Make HasAuthor table
$sql = "CREATE TABLE HasAuthor
(
callNumber CHAR(50) NOT NULL,
FOREIGN KEY (callNumber) REFERENCES Book(callNumber),
name CHAR(50) NOT NULL,
PRIMARY KEY(name)
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />HasAuthor table created successfully";
}
else{
  echo "<br />Error creating HA table: " . mysqli_error($con);
}
  
  
  

//Make HasSubject table
$sql = "CREATE TABLE HasSubject
(
callNumber CHAR(50) NOT NULL, 
subject CHAR(50) NOT NULL,
PRIMARY KEY(subject),
FOREIGN KEY (callNumber) REFERENCES Book(callNumber)
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />HasSubject table created successfully";
}
else{
  echo "<br />Error creating HS table: " . mysqli_error($con);
}
  

  
  
//Make BookCopy table
$sql = "CREATE TABLE BookCopy
(
callNumber CHAR(50) NOT NULL , 
copyNo INT NOT NULL,
CONSTRAINT pk_BookCopy PRIMARY KEY(callNumber, copyNo),
FOREIGN KEY (callNumber) REFERENCES Book(callNumber),
status CHAR(7)
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />BookCopy table created successfully";
}
else{
  echo "<br />Error creating BC table: " . mysqli_error($con);
}



//Make HoldRequest table
$sql = "CREATE TABLE HoldRequest
(
hid INT NOT NULL AUTO_INCREMENT,
bid INT NOT NULL,
callNumber CHAR(50) NOT NULL, 
PRIMARY KEY(hid),
FOREIGN KEY (callNumber) REFERENCES Book(callNumber),
FOREIGN KEY (bid) REFERENCES Borrower(bid),
issuedDate DATE
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />HoldRequest table created successfully";
}
else{
  echo "<br />Error creating HR table: " . mysqli_error($con);
}
  
  
//Make Borrowing table
$sql = "CREATE TABLE Borrowing
(
borid INT NOT NULL AUTO_INCREMENT,
bid INT NOT NULL,
callNumber CHAR(50) NOT NULL,
copyNo INT NOT NULL,
PRIMARY KEY(borid),
FOREIGN KEY (callNumber) REFERENCES Book(callNumber),
FOREIGN KEY (bid) REFERENCES Borrower(bid),
FOREIGN KEY (callNumber, copyNo) REFERENCES BookCopy(callNumber, copyNo),
outDate DATE,
inDate DATE
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />Borrowing table created successfully";
}
else{
  echo "<br />Error creating Borrowing table: " . mysqli_error($con);
}


//Make Borrowing table
$sql = "CREATE TABLE Fine
(
fid INT NOT NULL AUTO_INCREMENT,
borid INT NOT NULL,
PRIMARY KEY(fid),
FOREIGN KEY (borid) REFERENCES Borrowing(borid),
amount INT,
issuedDate DATE,
paidDate DATE
)"; 
  
// Execute query
if (mysqli_query($con,$sql)){
  echo "<br />Fine table created successfully";
}
else{
  echo "<br />Error creating Fine table: " . mysqli_error($con);
}  

?>