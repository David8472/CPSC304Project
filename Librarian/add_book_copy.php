<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
	
		$callNo = $_POST['callNumber'];
	
	if($_POST['callNumber']!=''  AND $_POST['mainAuthor']!='' AND $_POST['subject']!='') {
		$check = mysqli_query($con, "SELECT *
					FROM Book
					WHERE Book.callNumber=$callNo");
	
		if( !(mysqli_num_rows($check)>0) ) {
			//add book to library
			$sql1="INSERT INTO Book(callNumber, isbn, title, mainAuthor, publisher, year)
			VALUES('$_POST[callNumber]','$_POST[isbn]','$_POST[title]','$_POST[mainAuthor]','$_POST[publisher]','$_POST[year]')";
			if(!mysqli_query($con,$sql1)) {
				die('Error Book: ' . mysqli_error($con));	
			}
			$sql2="INSERT INTO HasAuthor(callNumber, name)
			VALUES('$_POST[callNumber]','$_POST[mainAuthor]')";
			if(!mysqli_query($con,$sql2)) {
				die('Error Author: ' . mysqli_error($con));	
			}
			
			$sql3="INSERT INTO HasSubject(callNumber, subject)
			VALUES('$_POST[callNumber]','$_POST[subject]')";
			if(!mysqli_query($con,$sql3)) {
				die('Error Subject: ' . mysqli_error($con));	
			}				
		}
		$results=mysqli_query($con,"SELECT *
			FROM BookCopy
			WHERE BookCopy.callNumber = $callNo");
		$copyNo=mysqli_num_rows($results)+1;
		$increment=mysqli_query($con, "INSERT INTO BookCopy(copyNo,callNumber,status)
					VALUES ('$copyNo','$callNo','IN')");
		
		echo "Book added";
	} else {
		echo "Missing a field, please try again";
	}
	}
	mysqli_close($con);
?>