<?php

    session_start();

    $id = $_SESSION["id"];

      include "../../errors.php";

      if($_SESSION["id"]=="")
      {
            header("Location: ../../index.php");
      }

      include ("../../errors.php");

      include "/databaseconnection.php";

      $type = $_SESSION["user_type"];

      $bool2=false;
      $bool3=false;
      $bool4=false;
      $bool5=false;

      $sql = "select module_privileges from user_roles where role_id = $id";

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

     if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
         {
            header("Location: ../../index.php");
         }
         
    if($_SESSION["user_type"]!="admin")
      {
              $_SESSION["error"]="Error...  You Hava No Permission To Access This Page";
              header("Location: ../users/index.php");
      }
      
      if($_GET['f'])
      {
         header("Location:"."../users/".$_GET['f']."/create.php");
      }
      if($_GET['h'])
      {
         header("Location:"."../users/".$_GET['h']."/index.php");
      }

      $id2 = (int)$_GET['id'];

      $sql = "select * from users where id='$id2'";

      $rows = $conn->query($sql);

      $row = $rows->fetch_assoc();

      $u_name=$row["user_name"];

      $u_email=$row["user_email"];

      $status=$row["user_status"];

      $ttt=$row["user_role_id"];

      $sqlrrr="select * from user_roles where role_id =$ttt";

      $resu = $conn->query($sqlrrr);

      $ro=$resu->fetch_assoc();

      $id_ref=$row["user_role_id"];

      $sqlForSelect="SELECT role_name FROM user_roles where role_id ='$id_ref'";

      $res = $conn->query($sqlForSelect);

      $res=$res->fetch_assoc();

      $name4=$res["role_name"];


      if ($_SERVER["REQUEST_METHOD"] == "POST") 
      {

        if (empty($_POST["name"])) 
        {
          $nameEr = "Name is Required";
        }
        else
        {
            $name = $_POST["name"];
            $u_name=$name;
            if (!preg_match("/^[a-zA-Z ]*$/",$name) || strlen($name)>50) 
            {
              if(strlen($name)>50)
              {
                $nameEr = "Name is Too Long....";
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
          $u_email=$email;
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
          {
            $emailErr = "Invalid Email Format"; 
          }
          else
          {
            $bool3=true;
          }
        }

            $user=$_POST["user_id"];
            if (empty($_POST["user_id"]))
            {
              $nameErr = "Please Select The User_Role";
            } 
            else 
            {
              $u = $_POST["user_id"];

              $id_ref=$_POST["user_id"];

              $sqlForSelect="SELECT role_name FROM user_roles where role_id ='$id_ref'";

              $res = $conn->query($sqlForSelect);

              $res=$res->fetch_assoc();

              $name4=$res["role_name"];

              $bool1=true;

              $nameErr="";
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

        if($bool2&&$bool3&&$bool5)
        {
          $name=$_POST["name"];
          $email=$_POST["email"];
          $role=$_POST["user_id"];
          echo $role;
          $sql="update users set user_name ='$name',user_email='$email',user_role_id=$role,user_status='$status' where id=$id2";
            if ($conn->query($sql) === TRUE) 
            {
              $error="";
              $_SESSION["user_update_success"]="The User is Updated Successfully";
              header("Location: list_users.php");
            }
            else 
            {
              $error="The User Cannot Be Updated";
              // echo "Error: " . $sql . "<br>" . $conn->error;
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

  <link rel="stylesheet" href="../../../bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="../../../bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="../../../bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="../../../dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../../../dist/css/style1.css">

  <link rel="stylesheet" href="../../../dist/css/skins/skin-blue.min.css">

  

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <style type="text/css">
    textarea
    {
      width: 300px;
    }
    p 
    {
      color: red;
    }
   </style>
   <script type="text/javascript">
    $('#user_role').val(<?php echo $country;?>);
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">

        <header class="main-header">

          <!-- Header Navbar -->
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
                        <a href="/logout.php" class="label-danger text-center btn" style="width: 150px;">Logout</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
          <aside class="main-sidebar">

                  <?php if($type=="admin") {?>
<!--                     <ul class="sidebar-menu" data-widget="tree"">
                      <li class="header" style="color: white;text-align: center;font-size: 20px;">Options</li>
                      <li><a href="user_role_management.php"><i class="fa fa-link"></i> <span>User role management</span></a></li>
                      <li><a href="index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
                      <li><a href="user_management.php"><i class="fa fa-link"></i> <span>User management</span></a></li>
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
                    <?php }?>

                    <ul class="sidebar-menu" data-widget="tree">
                    <?php if($type!="admin") {?>
                      <!-- <li class="header" style="color: white;text-align: center;font-size: 20px;">Options</li> -->
                      <?php } ?>

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
                              <li><a href="?h=<?php echo $newArray[$j]; ?>">List</a></li>
                              <?php }?>
                              <?php } ?>
                              </li>
                              </ul>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </ul>

          </aside>

        <div class="content-wrapper">
            <div style="background-color: white;height: 40px;margin-top: -10px;">
            <p style="color: red;font-size: 17px;text-align: center;"><?php echo $error; ?></p>
            <!-- <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>            -->
            </div>
            <section class="content container-fluid" style="text-align: center;">
            <!-- <p><?php echo $error; ?></p> -->
              <form method="post" style="margin-top: 50px;">
                <label>User Name  <input type="text" class="form-control" name="name" maxlength="50" value=<?php echo $u_name; ?>>
                </label>
                <p> <?php echo $nameEr;?></p>
                <br>
                <label>Email  <input type="text" class="form-control" name="email" maxlength="50" value=<?php echo $u_email;?>></label>
                <p><?php echo $emailErr;?></p>
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
                <label>Select The User Role</label><br>
                <select style="color: black;" id="user_role" name="user_id">

                    <!-- <option value="<?php echo $ro["role_id"] ?>"><?php echo $ro["role_name"] ?></option> -->
                    <option value="<?php echo $id_ref; ?>"><?php echo $name4; ?></option>
                   <?php while($rs=$result->fetch_assoc()){ if($ro["role_id"]!=$rs["role_id"]){?>
                        <option value="<?php echo $rs["role_id"]; ?>" ><?php echo $rs["role_name"] ?></option>
                   <?php }}?>

                </select> 
                <p> <?php echo $nameErr;?></p>
                <br>       
                <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">
                 <a href="list_users.php" class="btn btn-danger">Cancel</a>
              </form>
            </section>
        </div>

      </div>

    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../../../dist/js/adminlte.min.js"></script>

</html>