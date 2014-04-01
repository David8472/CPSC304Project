<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {

		//$n = $_POST['number'];
		//$year = $_POST['year'];
		$n = 5;
		$year = 1993;
		echo $n . " most popular books in " . $year . "\n";
		
		//most popular books
		$result=mysqli_query($con,"SELECT *
				     FROM Book
				     INNER JOIN Borrowing
				     ON Book.callNumber=Borrowing.callNumber
				     WHERE year=substr(Borrowing.outDate, 0, 4)
				     ORDERED BY Borrowing.borid");
		
		if (!$results)
		  {
		    die('Error: ' . mysqli_error($con));
		  }
	
		// table header
		echo "<table border='1'>
		<tr>
		<th>Call Number</th> 
		<th>ISBN</th>
		<th>Title</th>
		<th>Author</th>
		<th>Publisher</th>
		<th>Year</th>
		</tr>";
		//table items
		$x = 0;
		while($x <= $year) {
			while($row = mysqli_fetch_array($result)) {
				echo "<tr>";
				echo "<td>" . $row['callNumber'] . "</td>";
				echo "<td>" . $row['isbn'] . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['mainAuthor'] . "</td>";
				echo "<td>" . $row['publisher'] . "</td>";
				echo "<td>" . $row['year'] . "</td>";
				echo "</tr>";
			}
		$x++;
		}
		echo "</table>";
	}

	mysqli_close($con);
?>
