<?php
	$con=mysqli_connect("localhost","root","");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_query($con,"INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
	VALUES($_POST['callNumber'], $_POST['isbn'], $_POST['title'], $_POST['mainAuthor'], $_POST['publisher'], $_POST['year'])");

	mysqli_query($con,"INSERT INTO BookCopy(callNumber, status)
	VALUES($_POST['callNumber'], $_POST['status'])");

	mysqli_close($con);
?>
