<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		
		$x = '$_POST[callNumber]';
	
		$check = mysqli_query($con, "SELECT *
					FROM Book
					WHERE Book.callNumber=$x");
	
		if( !(mysqli_num_rows($check)>0) ) {
			//add book to library
			$sql1="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
			VALUES
			('$_POST[callNumber]', '$_POST[isbn]', '$_POST[title]', '$_POST[mainAuthor]', '$_POST[publisher]', '$_POST[year]')";
			//TEST
			/*$sql1="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
			VALUES
			(11111, 54321, 'hello', 'world', 'company', '1995')";*/
			if(!mysqli_query($con,$sql1)) {
				die('Error: ' . mysqli_error($con));	
			}
		}
		
		//add copy
		$sql2="INSERT INTO BookCopy(callNumber, status)
		VALUES
		('$_POST[callNumber]', '$_POST[status]')";
		//TEST
		/*$sql2="INSERT INTO BookCopy(callNumber, status)
		VALUES
		(11111, 'in')";*/
		
		if(!mysqli_query($con,$sql2)) {
			die('Error: ' . mysqli_error($con));	
		}
	
		echo "Book added";
	}
	mysqli_close($con);
?>