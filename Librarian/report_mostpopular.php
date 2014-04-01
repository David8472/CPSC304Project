<?php
	$con=mysqli_connect("localhost","root","", "DBCPSC304");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	} else {

		$n = $_POST['number'];
		$year = $_POST['year'];
		
		echo $n . " most popular books in " . $year . "\n";
		
		//most popular books
		$result=mysqli_query($con,"SELECT DISTINCT Book.callNumber, Book.isbn, Book.title, Book.mainAuthor, Book.publisher, Book.year, Borrowing.outDate
				     FROM Book
				     INNER JOIN Borrowing
				      ON Book.callNumber=Borrowing.callNumber
				     ORDER BY Borrowing.borid");
		
		if (!$result)
		  {
		    die('Error: ' . mysqli_error($con));
		  }
	
		if(mysqli_num_rows($result) > 0) {
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
			while($x <= $n) {
				while($row = mysqli_fetch_array($result)) {
					$ref_year = date("Y",strtotime("$row['outDate']"));
					if($year = $ref_year) {
						echo "<tr>";
						echo "<td>" . $row['callNumber'] . "</td>";
						echo "<td>" . $row['isbn'] . "</td>";
						echo "<td>" . $row['title'] . "</td>";
						echo "<td>" . $row['mainAuthor'] . "</td>";
						echo "<td>" . $row['publisher'] . "</td>";
						echo "<td>" . $row['year'] . "</td>";
						echo "</tr>";
					}
				}
			$x++;
			}
			echo "</table>";
		}
	}

	mysqli_close($con);
?>