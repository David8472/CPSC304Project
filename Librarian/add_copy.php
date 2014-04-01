<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	//TEST
	$sql="INSERT INTO BookCopy(callNumber, status)
	VALUES
	(999777, 'in')";

	//add copy
	/*$sql="INSERT INTO BookCopy(callNumber, status)
	VALUES
	('$_POST[callNumber]', '$_POST[status]')";*/
	
	if(!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error($con));	
	}

	mysqli_close($con);
?>
