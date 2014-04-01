<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$sql="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
	VALUES
	(555666, 54321, 'hello', 'world', 'company', '1995')";

	//add book to library
	/*$sql="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
	VALUES
	('$_POST[callNumber]', '$_POST[isbn]', '$_POST[title]', '$_POST[mainAuthor]', '$_POST[publisher]', '$_POST[year]')";*/
	
	if(!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));	
	}

	mysqli_close($con);
?>
