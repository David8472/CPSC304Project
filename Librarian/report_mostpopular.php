<?php
	$con=mysqli_connect("localhost","root","");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//most popular books
	$result=mysqli_query($con,"SELECT * FROM Book A, Borrowing B WHERE A.callNumber=B.callNumer AND year=substr(B.outDate, 0, 4) ORDERED BY B.borid");
	echo $_POST['number'] . " most popular books in " . $_POST['year'] . "\n";

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
	while($x <= $_POST['number']) {
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

	mysqli_close($con);
?>
