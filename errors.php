<?php 
      session_start();

	   $ide = $_SESSION["userid"];

	    $servername = "localhost";
      $username = "root";
      $password = "ndot";

      $conn = new mysqli($servername, $username, $password,"SASI");

      if($conn->connect_error) 
      {
        die("Connection failed: " . $conn->connect_error);
      }
      else
      {
        echo "";
      }
      $sql2="select user_status from users where id=$ide";

      $result  = $conn->query($sql2);

      $row = $result->fetch_assoc();

      $sta= $row["user_status"];

	if($sta=="A")
	{
    
	}
	else
	{
		header("Location:/logout.php?err='blocked");

    $_SESSION["blocked_error"]="You Are Blocked By Admin";

    echo $_SESSION["blocked_error"];

	}
?>