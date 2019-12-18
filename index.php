    <?php
      session_start();

            $servername = "localhost";
            $username = "root";
            $password = "ndot";
            $bool=false;
            $bool2=false;
            $bool3=false;

            if ($_GET['msg'])
            {
              $success="You Have Been Successfully Logged Out";
            }
            else
            {
              $error="You are Blocked By Admin";
            }

            if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
              {
              echo "";
              }
           else
           {
              header("Location: dashboard.php");
           }

            $conn = new mysqli($servername, $username, $password,"SASI");

            if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            }
            else
            {
              // echo "Connected";
            }

      if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
              $user = $_POST["username"];
              $pass = $_POST["pass"];


                if (empty($_POST["username"])) 
                {
                  $nameErr = "User Name is Required";
                }
                else
                {
                  $user = $_POST["username"];
                  if (!preg_match("/^[a-zA-Z ]*$/",$user)) 
                  {
                    if(strlen($user)>50)
                    {
                      $nameErr = "The Name is Too Long"; 
                    }
                    else
                    {
                      $nameErr = "Please Enter Valid Username";
                    }
                    
                  }
              }

              if (empty($_POST["pass"])) 
                {
                  $passErr = "Password is Required";
              }
                else
                {
                  $pass = $_POST["pass"];
                  $check_Password=md5($pass);
              }


              if($user==""||$pass=="")
              {
                $bool=false;
              }
              else
              {
                $bool=true;
              }

              if($bool)
              {
                $sql = "SELECT id,user_name,password,user_role_id,user_status FROM users where user_name='$user' or user_email ='$user' AND password='$check_Password'";

                $result2 = $conn->query($sql);

                $finalRow= $result2->num_rows;

                $row = $result2->fetch_assoc();

                if($finalRow==1)
                {

                  if($row["user_status"]=="B")
                  {
                    echo "<p>"."The User Has Been Blocked By Admin"."</p>";
                  }
                  else
                  {
                    $_SESSION["id"]=$row["user_role_id"];
                    $_SESSION["user_status"]=$row["user_status"];
                    $_SESSION["user"]=$row["user_name"];                    
                    $_SESSION["userid"]=$row["id"];
                    $role=$row["user_role_id"];
                    $sqlForUserType="select role_name from user_roles where role_id =$role";
                    $userType= $conn->query($sqlForUserType);
                    $userTy=$userType->fetch_assoc();
                    $_SESSION["user_type"]=$userTy["role_name"];
                    header("Location:dashboard.php");
                  } 
                }
                else
                {
                  echo "Invalid Username and Password";
                }
            }
        }
    ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script type="text/javascript">
        window.onload = function () { 
          setInterval(function(){
            document.getElementById("ddd").innerHTML ="";
          },3000)
    }
  </script>

	<style type="text/css">

		body
    {
			text-align: center;
			margin-top: 15%;
		}

	</style>

  <script type="text/javascript">
    window.onload = function () { 
      setInterval(function(){
      document.getElementById("ddd").innerHTML ="";
      },5000)
    }
  </script>


</head>
<body>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p id="ddd" style="color: green"><?php echo $success; ?></p>
     <p id="ddd" style="color: red"><?php echo $error; ?></p>
		<label>Username  <input type="text" class="form-control" name="username" maxlength="50" value="<?php echo $user;?>">
		</label>
		<br>
		<p> <?php echo $nameErr;?></p><p> <?php echo $valErr;?></p>
		<label>Password  <input type="password" class="form-control" name="pass" maxlength="16" value="<?php echo $pass;?>"></label>
		<br>
		<p> <?php echo $passErr;?></p><p> <?php echo $valErr2;?></p>
		<input type="submit" name="submit" class="btn btn-primary" value="LOGIN">
	</form>	

</body>
</html>