<?php

$con=mysqli_connect("localhost","root","", "DBCPSC304");
// Check connection
if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$bid = $_POST['bid'];

$bookList = array($_POST['callNumber1'],$_POST['callNumber2'],$_POST['callNumber3'],$_POST['callNumber4'],$_POST['callNumber5']);

$numOfBooks = count($bookList);
$stack=array();
$today = date('m-d-Y');

if(!empty($bid)) {
$result=mysqli_query($con,"SELECT *
                      FROM Borrower
                      INNER JOIN BorrowerType
                        ON Borrower.type = BorrowerType.type
                      WHERE bid = $bid");
  if(mysqli_num_rows($result)>0) {
      $row = mysqli_fetch_array($result);
      $name=$row['name'];
      echo "User $name has been found<br>";
      $type=$row['type'];
      $days=intval($row['bookTimeLimit']);
      if($row['expiryDate'] < $today){
        echo "Card has expired<br>";
      } else {
        foreach($bookList as $book)
          {
              if($book != null) {
                if($type == 'Faculty'){
                  $available = mysqli_query($con,"SELECT copyNo
                                            FROM BookCopy
                                            INNER JOIN Book on BookCopy.callNumber = $book
                                            WHERE status = 'IN'
                                              OR status = 'ON-HOLD'
                                            LIMIT 1");
                } else {
                  $available = mysqli_query($con,"SELECT copyNo
                                            FROM BookCopy
                                            INNER JOIN Book on BookCopy.callNumber = $book
                                            WHERE status = 'IN'
                                            LIMIT 1");
                }
                  if(mysqli_num_rows($available) > 0) {
                    $row = $available->fetch_assoc();
                    $copyNo =  $row["copyNo"];
                    echo "$book copy $copyNo is available<br>";
                    mysqli_query($con,"UPDATE BookCopy
                                 SET status='OUT'
                                 WHERE callNumber = $book
                                  AND copyNo = $copyNo");
                    $outDate=date("Y-m-d");
                    $dueDate=date("m-d-Y",mktime(0,0,0,date("m"),date("d")+$days,date("Y")));
                    $sql="INSERT INTO Borrowing
                    (bid, callNumber, copyNo, outDate, inDate)
                    VALUES
                    ($bid,$book,$copyNo,'$outDate','0-0-0')";
                    
                    // Check for errors
                    if (!mysqli_query($con,$sql))
                      {
                        die('Error: ' . mysqli_error($con));
                      }
                    array_push($stack,array("$book","$copyNo","$dueDate"));
                  } else echo "$book is not available<br>";
              }
          }
          
          echo"<table border ='1'><tr><th>
          Books Borrowed This Transaction
          </th></tr></table>";
          
          echo"<table border='1'><tr>
          <th>Catalogue No</th>
          <th>Due</th>
          </tr>";
          // Method 1 Selects all items from this submission
          for($x=0;$x<count($stack);$x++){
            echo"<tr>";
            echo"<td>".$stack[$x][0]."-".$stack[$x][1]."</td>";
            echo"<td>".$stack[$x][2]."</td>";
            echo"</tr>";
          }
          echo"</table>";
          // Method 2 Selects all items related to that bid
          $results = mysqli_query($con,"SELECT *
                                    FROM Borrowing
                                    WHERE bid = $bid
                                      AND inDate = '0000-00-00'
                                    ORDER BY outDate");
          
          echo"<table border ='1'><tr><th>
            All Books Borrowed, Not Yet Returned
            </th></tr></table>";
          echo"<table border='1'><tr>
            <th>Catalogue No</th>
            <th>Due</th>
            </tr>";
          while($row = mysqli_fetch_array($results))
            {
              $outDate=$row['outDate'];
              $dueDate = date("m-d-Y",strtotime("$outDate + $days day"));
              echo"<tr>";
              echo"<td>".$row['callNumber']."-".$row['copyNo']."</td>";
              echo"<td>".$dueDate."</td>";
              echo"</tr>";
            }
          echo"</table>";
      }
  } else {
      echo "Not a valid borrower id.";
  }
} else echo "Please enter a borrower id.";
mysqli_close($con);
?>