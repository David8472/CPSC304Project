<?php
	$con=mysqli_connect("localhost","root","");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//add book to library
	$sql1="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
	VALUES
	('$_POST[callNumber]', '$_POST[isbn]', '$_POST[title]', '$_POST[mainAuthor]', '$_POST[publisher]', '$_POST[year]')";
	
	if(!mysqli_query($con,$sql1)) {
		die('Error: ' . mysqli_error($con));	
	}

	//add copy
	$sql2="INSERT INTO BookCopy(callNumber, status)
	VALUES
	('$_POST[callNumber]', '$_POST[status]')";
	
	if(!mysqli_query($con,$sql2)) {
		die('Error: ' . mysqli_error($con));	
	}

	mysqli_close($con);
?>
