<?php
	$con=mysqli_connect("localhost","root","");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_query($con,"DELETE FROM Borrower WHERE bid=($_POST['borrower_id'])");

	mysqli_close($con);
?>
