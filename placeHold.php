<?php
$db_con=mysqli_connect("localhost","root","", "DBCPSC304");
	if($db_con){
		$place = "INSERT INTO HoldRequest(bid, callNumber, issuedDate)
				VALUES('{$_POST['bid']}','{$_POST['callNumber']}',NOW())";
		$result =  mysqli_query($db_con,$place);
		
		if($result){
			echo "Hold has been successfully placed";
		}
		else{
			echo "Hold has not been placed";
		}
	}
		
	else{
		echo "Connection Failed";
	}

?>