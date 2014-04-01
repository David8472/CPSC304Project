<?php
$db_con=mysqli_connect("localhost","root","", "DBCPSC304");
	echo "Borrower #{$_POST['bid']}<br><br>";
	if($db_con){
		echo "Current Holds:<br>";
		$holds="SELECT *
				FROM HoldRequest
				INNER JOIN Book ON HoldRequest.callNumber = Book.callNumber
				WHERE HoldRequest.bid = '{$_POST['bid']}'";
		$result1 = mysqli_query($db_con,$holds);
			while($row = mysqli_fetch_array($result1))
			{
				echo "You have on hold '" . $row['title'] . "' since " . $row['issuedDate'] . "<br>";
			}
			echo "<br>";
			 
		echo "Currently Borrowing:<br>";
		$borrowing = "SELECT *
					FROM Borrowing
					INNER JOIN Book on Borrowing.callNumber = Book.callNumber
					WHERE bid = '{$_POST['bid']}' AND inDate IS NULL";
		$result2 = mysqli_query($db_con,$borrowing);
			while($row = mysqli_fetch_array($result2))
			{
				echo "You have borrowed the book '" . $row['title'] . "' since " . $row['outDate'] . "<br>";
			}
			echo "<br>";
			
		echo "Current Fines:<br>";
		$fines = "SELECT * 
				FROM Fine
				INNER JOIN Borrowing ON Borrowing.bid = '{$_POST['bid']}'
				INNER JOIN Book on Borrowing.callNumber = Book.callNumber
				WHERE paidDate IS NULL";
		$result3 = mysqli_query($db_con,$fines);
		while($row = mysqli_fetch_array($result3))
			{
				echo "You must pay a fine of $" . $row['amount'] . " on the book '" . $row['title'] . "'<br>";
			}
		echo "<br>";
	}
		
	else{
		echo "Connection Failed";
	}

?>