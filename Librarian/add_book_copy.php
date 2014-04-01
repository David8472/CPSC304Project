<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		$increment = 0;
		$x = $_POST['callNumber'];
	
	if($_POST['callNumber']!=''  AND $_POST['mainAuthor']!='' AND $_POST['subject']!='') {
		$check = mysqli_query($con, "SELECT *
					FROM Book
					WHERE Book.callNumber=$x");
	
		if( !(mysqli_num_rows($check)>0) ) {
			//add book to library
				$sql1="INSERT INTO Book(callNumber, isbn, title, mainAuthor, publisher, year)
				VALUES('$_POST[callNumber]','$_POST[isbn]','$_POST[title]','$_POST[mainAuthor]','$_POST[publisher]','$_POST[year]')";
				//TEST
				/*$sql1="INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
				VALUES
				(11111, 54321, 'hello', 'world', 'company', '1995')";*/
				if(!mysqli_query($con,$sql1)) {
					die('Error: ' . mysqli_error($con));	
				}
				$sql2="INSERT INTO HasAuthor(callNumber, name)
				VALUES('$_POST[callNumber]','$_POST[mainAuthor]')";
				if(!mysqli_query($con,$sql2)) {
					die('Error: ' . mysqli_error($con));	
				}
				
				$sql3="INSERT INTO HasSubject(callNumber, subject)
				VALUES('$_POST[callNumber]','$_POST[subject]')";
				if(!mysqli_query($con,$sql3)) {
					die('Error: ' . mysqli_error($con));	
				}
		 
		
			//add copy
			$sql4="INSERT INTO BookCopy(callNumber, copyNo,status)
			VALUES('$_POST[callNumber]', 0, 'IN')";
			//TEST
			/*$sql2="INSERT INTO BookCopy(callNumber, status)
			VALUES
			(11111, 'in')";*/
			
			if(!mysqli_query($con,$sql4)) {
				die('Error: ' . mysqli_error($con));	
			}	
		} else {
			$increment=mysqli_query($con, "UPDATE BookCopy
							SET copyNo=copyNo+1
							WHERE callNumber = '{$_POST['callNumber']}'");
			if(!mysqli_query($con,$increment)) {
				die('Error increment: ' . mysqli_error($con));	
			}
		}
		echo "Book added";
	} else {
		echo "Missing a field, please try again";
	}
	}
	mysqli_close($con);
?>