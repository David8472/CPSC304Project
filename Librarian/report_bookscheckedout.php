<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {
		
		echo "Report of books checked out: <br>";
		//test
		/*$sql="INSERT INTO HasSubject (callNumber, subject)
			VALUES
			(12345, 'horror')";
		if(!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));	
		}*/
		$subject = $_POST['subject'];
		$today = date('Y-m-d');
		
		//if has subject or doesn't
		//if(!empty($_POST['searchsubject'])) {
		if(!empty($subject)) {
			$result=mysqli_query($con, "SELECT *
						FROM BookCopy
						INNER JOIN HasSubject
						 ON BookCopy.callNumber=HasSubject.callNumber
						INNER JOIN Borrowing Borrowing
						 ON HasSubject.callNumber=Borrowing.callNumber
						INNER JOIN Borrower
						 ON Borrowing.bid = Borrower.bid
						INNER JOIN BorrowerType
						 ON Borrower.type = BorrowerType.type
						WHERE BookCopy.status='OUT'
						 AND BookCopy.copyNo = Borrowing.copyNo AND HasSubject.subject='$subject'
						ORDER BY BookCopy.callNumber");
		//echo "Subject: " . $_POST['searchsubject' . "\n"];
		echo "Subject: " . $subject . "<br>";
		} else {
			$result=mysqli_query($con, "SELECT *
						FROM BookCopy
						INNER JOIN Borrowing Borrowing
						 ON BookCopy.callNumber=Borrowing.callNumber
						INNER JOIN Borrower
						 ON Borrowing.bid = Borrower.bid
						INNER JOIN BorrowerType
						 ON Borrower.type = BorrowerType.type
						WHERE BookCopy.status='OUT'
						 AND BookCopy.copyNo = Borrowing.copyNo
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
				$outDate=$row['outDate'];
				$days=$row['bookTimeLimit'];
				$dueDate = date("Y-m-d",strtotime("$outDate + $days day"));
				echo "<tr>";
				echo "<td>" . $row['callNumber'] . "-".$row['copyNo']."</td>";
				echo "<td>" . $row['outDate'] . "</td>";
				echo "<td>" . $dueDate . "</td>";
				if($dueDate < $today) {
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