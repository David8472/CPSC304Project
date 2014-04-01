<?php
$db_con=mysqli_connect("localhost","root","", "DBCPSC304");
	if($db_con){
		$paid = "UPDATE Fine
				SET paidDate= NOW()
				WHERE fid='{$_POST['fid']}'";
		$result =  mysqli_query($db_con,$paid);
		if($result){
			echo "Fine has been successfully paid";
		}
		else{
			echo "Fine not successfully paid";
		}
	}
	else{
		echo "Connection Failed";
	}

?>