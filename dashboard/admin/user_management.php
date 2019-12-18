<?php

    session_start();
    $id = $_SESSION["id"];

      if($_SESSION["id"]=="")
      {
            header("Location: ../../index.php");
      }

      include "../../errors.php";

      include "/databaseconnection.php";
    
      $bool1=false;
      $bool2=false;
      $bool3=false;
      $bool4=false;
      $bool5=false;
      $id_ref="";
      $name4="Select the role";

      $sql = "select module_privileges from user_roles where role_id = $id";

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

      if($_GET['f'])
      {
         header("Location:"."../users/".$_GET['f']."/create.php");

      }
      $_GET['f']="";
      if($_GET['i'])
      {
         header("Location:"."../users/".$_GET['i']."/index.php");
      }

     if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
      {
        header("Location: ../../index.php");
      }
     else 
     {
        if($_SESSION["user_type"]!="admin")
           {
              $_SESSION["error"]="Error...  You Hava No Permission To Access This Page";
              header("Location: ../users/index.php");
           }
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") 
      {

        $user=$_POST["user_role"];
        if (empty($_POST["user_role"]))
        {
          $nameErr = "Please Select The User_Role";
        } 
        else 
        {
          $u = $_POST["user_role"];
          $id_ref=$_POST["user_role"];
          $sqlForSelect="SELECT role_name FROM user_roles where role_id ='$id_ref'";
          $res = $conn->query($sqlForSelect);
          $res=$res->fetch_assoc();
          $name4=$res["role_name"];
          $bool1=true;
          $nameErr="";
        }


        if (empty($_POST["name"])) 
        {
          $nameEr = "Name is required";
        }
        else
        {
            $name = $_POST["name"];
            if (!preg_match("/^[a-zA-Z ]*$/",$name) || strlen($name)>50) 
            {
              if(strlen($name)>50)
              {
                $nameEr = "Name is too Long....";
              }
              else
              {
                $nameEr = "Please Enter Valid Name";
              }
            }
            else
            {
              $bool2=true;
            }
          }


        if (empty($_POST["email"])) 
        {
          $emailErr = "Email is Required";
        } 
        else 
        {
          $email = $_POST["email"];
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
          {
            $emailErr = "Invalid Email Format"; 
          }
          else
          {
            $bool3=true;
          }
        }

        $pass = $_POST["password"];

        $uppercase = preg_match('@[A-Z]@', $pass);

        $lowercase = preg_match('@[a-z]@', $pass);

        $number    = preg_match('@[0-9]@', $pass);
        
        $specialChars = preg_match('@[^\w]@', $pass);

        if(empty($pass))
        {
          $passErr="The Password is Required";
        }
        else
        {
          if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass) < 8) 
          {
              $passErr = 'Password Should Be at Least 8 Characters In Length and Should Include at Least One Upper Case Letter, One Number, and One Special Character.';
          }
          else
          {
              $passErr='';
              $bool4=true;
              $encryptedPassword = md5($pass);
          }
        }

        if(empty($_POST["radio"]))
        {
          $statusErr="The User Status is Required";
        }
        else
        {
           $statusErr="";
           $bool5=true;
          $status= $_POST["radio"];
        }
        if($bool1&&$bool2&&$bool3&&$bool4&&$bool5)
        {
          $sqlForEmailValidation="select user_email from users where user_email='$email'";
          if($conn->query($sqlForEmailValidation)->num_rows!=0)
          {
              $error="The Email Id is Already Exists";
          }
          else
          {
          $sql="insert into users(user_name,user_email,user_role_id,password,user_status) values('$name','$email',$u,'$encryptedPassword','$status')";
            if ($conn->query($sql) === TRUE) 
            {
              $error="";
              $_SESSION["user_insert_success"]="The User Sucessfully Inserted";
              header("Location: list_users.php");
            }
            else 
            {
              $error="Error....The User Cannot Be inserted";
              // echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
      }      
?>

<?php

if(isset($_POST['submit'])){
if(!empty($_POST['check_list']))
  
{
foreach($_POST['check_list'] as $selected){
echo $selected."</br>";
}
}
}
?>


<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Dashboard</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../../dist/css/style1.css">

  <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  

  <style type="text/css">
    p 
    {
      color: red;
    }
  </style>

  <script type="text/javascript">
        window.onload = function () { 
          setInterval(function(){
            document.getElementById("suc").innerHTML ="";
          },3000)
    }
  </script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">

        <header class="main-header">

        <nav class="navbar navbar-static-top" role="navigation">
               <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li class="dropdown user user-menu" >
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs" style="font-size: 20px;margin-right: 50px;display: inline-block;">Welcome 
                    <?php echo $_SESSION["user"]?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                        <a href="../../logout.php" class="label-danger text-center btn" style="width: 150px;">Logout</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
          <aside class="main-sidebar">
            <section class="sidebar">
<!--               <ul class="sidebar-menu" data-widget="tree"">
                <li class="header" style="color: white;text-align: center;font-size: 20px;">Options</li>
                <li><a href="user_role_management.php"><i class="fa fa-link"></i> <span>User role management</span></a></li>
                <li><a href="index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
                </li>
                <li><a href="#"><i class="fa fa-link"></i> <span>User management</span></a></li>
                <li><a href="list_users.php"><i class="fa fa-link"></i> <span>List User</span></a>
                </li>
              </ul> -->
                            <ul class="sidebar-menu" data-widget="tree"">
                <!-- <li class="header" style="color: white;text-align: center;font-size: 20px;">Options</li> -->
                            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>User Role Management</span>
                              <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                             </a>
                             <ul class="treeview-menu" >
                                <li ><a href="user_role_management.php"><i class="fa fa-link"></i> <span>Create</span></a></li>
                                <li><a href="index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
                                </li>
                            </li>
                             </ul>

                            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>User Management</span>
                              <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                             </a>
                             <ul class="treeview-menu" >
                                  <li><a href="user_management.php"><i class="fa fa-link"></i> <span>Create User</span></a></li>
                                  <li><a href="list_users.php"><i class="fa fa-link"></i> <span>List User</span></a>
                                  </li>
                             </li>
                             </ul>
                    </ul>
                    <ul class="sidebar-menu" data-widget="tree">
                        <?php for ($i=0; $i <= count($newArray); $i++) 
                        { 
                            if($i==count($newArray))
                            {
                              for($j=0;$j<count($newArray);$j++)
                        { ?>
                            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span><?php echo ucfirst($newArray[$j]); ?></span>
                              <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                             </a>
                             <ul class="treeview-menu" >
                        <?php  
                        $count=count($Privileges[$newArray[$j]]);
                        for($k=0; $k<$count; $k++) {  ?>
                              <?php if($Privileges[$newArray[$j]][$k]=="create") {?>
                              <li><a  href="?f=<?php echo $newArray[$j]; ?>">Create</a></li>
                              <?php }?>
                              <?php if($Privileges[$newArray[$j]][$k]=="read") {?>
                              <li><a href="?i=<?php echo $newArray[$j]; ?>">List</a></li>
                              <?php }?>
                              <?php } ?>
                              </li>
                              </ul>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </ul>
            </section>
          </aside>

        <div class="content-wrapper">
            <div style="background-color: white;height: 40px;">
            <p style="color: red;text-align: center;padding: 10px;"><?php echo $error; ?></p>
            <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>           
            </div>
            <section class="content container-fluid" style="text-align: center;">
            <!-- <p><?php echo $error; ?></p> -->
            <!-- <p style="color: green;" id="suc"><?php echo $success; ?></p> -->
              <form method="post" style="margin-top: 50px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label>User Name : <input type="text" class="form-control" name="name" maxlength="50" value=<?php echo $name; ?>>
                </label>
                <p> <?php echo $nameEr;?></p>
                <br>
                <label>Email : <input type="text" class="form-control" name="email" maxlength="50" value=<?php   echo $email; ?>></label>
                <p><?php echo $emailErr;?></p>
                <br>
                <label>Password : <input type="password" class="form-control" name="password" 
                value="<?php echo $pass ?>" maxlength="16" ></label>
                <p><?php echo $passErr; ?></p>
                <br>

                <label>User Status</label><br>
                <input type="radio" name="radio" value="A" <?php if($status=="A"){ ?> checked="checked" <?php }?>>Active&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="radio" value="B" <?php if($status=="B"){ ?> checked="checked" <?php }?>>Blocked
                <br>
                <p><?php echo $statusErr; ?></p>

                <?php 
                    $sql="SELECT * FROM user_roles";
                    $result = $conn->query($sql);
                ?>
                <select style="color: black;" id="user_role" name="user_role">

                    <option value="<?php echo $id_ref ?>"><?php echo $name4; ?></option>
                   <?php while($rs=$result->fetch_assoc()){ if($id_ref!=$rs["role_id"]) {?>
                        <option value="<?php echo $rs["role_id"]; ?>" ><?php echo $rs["role_name"] ?></option>
                   <?php }}?>

                </select> 
                <p><?php echo $nameErr ?></p>
                <br>             
                <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">
              </form>
            </section>

        </div>
      </div>
</body>


<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../../dist/js/adminlte.min.js"></script>

</html>