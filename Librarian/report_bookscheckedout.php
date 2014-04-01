<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		
		echo "Report of books checked out: <br>";
		//test
		/*mysqli_query($con, "INSERT INTO Book (callNumber, isbn, title, mainAuthor, publisher, year)
			     VALUES(12345, 54321, 'hello', 'james', 'worms', 1992)");
		mysqli_query($con, "INSERT INTO Borrowing (borid, bid, callNumber, copyNo, outDate, inDate)
			     VALUES(1, 234, 12345, 3, 1993, 1994)");
		mysqli_query($con, "INSERT INTO BookCopy (callNumber, status)
			     VALUES(12345, 'out')");*/
	
		/*$sql="INSERT INTO HasSubject (callNumber, subject)
			VALUES
			(12345, 'horror')";
		if(!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));	
		}*/
		$localtime = localtime();
		
		$type = 'horror';
		
		//if has subject or doesn't
		//if(!empty($_POST['searchsubject'])) {
		if(!empty($type)) {
			$result=mysqli_query($con, "SELECT *
						FROM BookCopy
						INNER JOIN Borrowing
						 ON BookCopy.callNumber=Borrowing.callNumber
						INNER JOIN HasSubject
						 ON HasSubject.callNumber=BookCopy.callNumber
						WHERE BookCopy.status='out' AND HasSubject.subject='$type'
						ORDER BY BookCopy.callNumber");
		//echo "Subject: " . $_POST['searchsubject' . "\n"];
		echo "Subject: " . $type . "<br>";
		} else {
			$result=mysqli_query($con, "SELECT *
						FROM BookCopy
						INNER JOIN Borrowing
						 ON BookCopy.callNumber=Borrowing.callNumber
						WHERE BookCopy.status='out'
						ORDER BY BookCopy.callNumber");
		}
		
		if (!$result)
		  {
		    die('Error: ' . mysqli_error($con));
		  }
		
		if(mysqli_num_rows($result) > 0) {
			// table header
			echo "<table border='1'>
			<tr>
			<th>Call Number</th> 
			<th>Check out date</th>
			<th>Due date</th>
			<th>Overdue</th>
			</tr>";
			//table items
			while($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				echo "<td>" . $row['callNumber'] . "</td>";
				echo "<td>" . $row['outDate'] . "</td>";
				echo "<td>" . $row['inDate'] . "</td>";
				if($localtime > '$row[inDate]') {
					echo "<td>" . 'YES' . "</td>";
				} else {
					echo "<td>" . 'NO' . "</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	
	mysqli_close($con);
?>
