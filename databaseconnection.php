<?php 

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

 ?>

