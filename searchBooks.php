<?php
$db_con=mysqli_connect("localhost","root","", "DBCPSC304");
	if($db_con){
	
		if($_POST['title']=='' AND $_POST['author']=='' AND $_POST['subject'] =='')
			echo "Empty search fields, please try again.<br>";
			
		else if($_POST['author']=='' AND $_POST['subject'] ==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					WHERE title LIKE '{$_POST['title']}'";
			echo "You are searching for books with Title:'{$_POST['title']}' <br>";
		}
		
		else if($_POST['title']=='' AND $_POST['subject'] ==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasAuthor ON Book.callNumber = HasAuthor.callNumber
					WHERE name LIKE '{$_POST['author']}'";
			echo "You are searching for books with Author: '{$_POST['author']}' <br>";
		}
		
		else if($_POST['title']=='' AND $_POST['author']==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasSubject ON Book.callNumber = HasSubject.callNumber 
					WHERE subject LIKE '{$_POST['subject']}'";
			echo "You are searching for books with Subject: '{$_POST['subject']}' <br>";
		}
		
		else if($_POST['title']==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasSubject ON Book.callNumber = HasSubject.callNumber 
					INNER JOIN HasAuthor ON Book.callNumber = HasAuthor.callNumber
					WHERE subject LIKE '{$_POST['subject']}' AND name LIKE '{$_POST['author']}'";
			echo "You are searching for books with Author: '{$_POST['author']}' and Subject: '{$_POST['subject']}' <br>";
		}
		
		else if($_POST['author']==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasSubject ON Book.callNumber = HasSubject.callNumber
					WHERE title LIKE '{$_POST['title']}' AND subject LIKE '{$_POST['subject']}'";
			echo "You are searching for books with Title:'{$_POST['title']}' and Subject: '{$_POST['subject']}' <br>";
		}
		
		else if($_POST['subject'] ==''){
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasAuthor ON Book.callNumber = HasAuthor.callNumber
					WHERE title LIKE '{$_POST['title']}' AND name LIKE '{$_POST['author']}'";
			echo "You are searching for books with Title:'{$_POST['title']}' and Author: '{$_POST['author']}' <br>";
		}
		
		else{
			$books = "SELECT * 
					FROM Book
					INNER JOIN BookCopy ON Book.callNumber = BookCopy.callNumber
					INNER JOIN HasSubject ON Book.callNumber = HasSubject.callNumber 
					INNER JOIN HasAuthor ON Book.callNumber = HasAuthor.callNumber
					WHERE title LIKE '{$_POST['title']}'";
			echo "You are searching for books with Title:'{$_POST['title']}' and Author: '{$_POST['author']}' and Subject: '{$_POST['subject']}'<br>";
		}
		
		$result = mysqli_query($db_con,$books);
		if($result){
			echo "Search Results:<br>";
			while($row = mysqli_fetch_array($result))
			  {
			  echo $row['title'] . " copy #" . $row['copyNo'] . " is currently " . $row['status'] . "<br>";
			  }
		}
		else{
			echo "Query Failed.<br>";
		}
	}
		
	else{
		echo "Connection Failed";
	}
?>