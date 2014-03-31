<?php
	$con=mysqli_connect("localhost","root","");
	// Check connection
	if (mysqli_connect_errno()){
	  echo "<br />Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	//if has subject or doesn't
	if(!empty($_POST['searchsubject'])) {
		$result=mysqli_query($con,"SELECT * FROM Book A, Borrowing B, HasSubject C WHERE C.subject=searchsubject AND B.callNumber=C.callNumber AND A.callNumber=B.callNumber ORDER BY B.callNumber");
	echo "Subject: " . $_POST['searchsubject' . "\n"];
	} else {
		$result=mysqli_query($con,"SELECT * FROM Book A, Borrowing B, HasSubject C WHERE A.callNumber=B.callNumber ORDERED BY B.callNumber");
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
	<th>Check out date</th>
	<th>Due date</th>
	</tr>";
	//table items
	while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>" . $row['callNumber'] . "</td>";
		echo "<td>" . $row['isbn'] . "</td>";
		echo "<td>" . $row['title'] . "</td>";
		echo "<td>" . $row['mainAuthor'] . "</td>";
		echo "<td>" . $row['publisher'] . "</td>";
		echo "<td>" . $row['year'] . "</td>";
		echo "<td>" . $row['outDate'] . "</td>";
		echo "<td>" . $row['inDate'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	mysqli_close($con);
?>