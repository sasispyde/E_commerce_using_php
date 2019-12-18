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

          if (empty($_POST["name"])) 
          {
            $nameErr = "Name is required";
          }
          else
          {
            $name = $_POST["name"];
            if (!preg_match("/^[a-zA-Z ]*$/",$name) || strlen($name)>50) 
            {
              if(strlen($name)>50)
              {
                $nameErr = "Name is too Long....";
              }
              else
              {
                 $nameErr = "Please Enter Valid Name";
              }
            }
            else
            {
              $bool1=true;
            }
          }

          $privileges=$_POST["options"];

          $result = serialize($privileges);

          // print_r($result);

          // print_r(unserialize($result));

          if(count($privileges)<=0)
          {
            $preErr = "Please Select The privileges";           
          }
          else
          {
            $bool2 =true;
            $preErr = "";           
          }

          if($bool1 && $bool2)
          {
            $sql="insert into user_roles (role_name,module_privileges)values('$name','$result')";
            
            if ($conn->query($sql) === TRUE) 
            {
              $_SESSION["success"]="The User Role Successfully Created";
              $error="";
              header("Location: index.php");

            }
            else 
            {
              $error="Their is an Error To Insert a Data In Database";
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

<!--                 <li ><a href="#"><i class="fa fa-link"></i> <span>User role management</span></a></li>
                <li><a href="index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
                </li> -->
<!--                 <li><a href="user_management.php"><i class="fa fa-link"></i> <span>User management</span></a></li>
                <li><a href="list_users.php"><i class="fa fa-link"></i> <span>List User</span></a>
                </li> -->
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
            <div style="background-color: white;height: 40px;margin-top: -10px;">
            <p style="color: red;font-size: 17px;text-align: center;"><?php echo $error; ?></p>
            <!-- <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>            -->
            </div>
            <section class="content container-fluid" style="text-align: center;">
            <!-- <p style="color: red"><?php echo $error; ?></p> -->
              <form method="post" style="margin-top: 50px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label>User Role  <input type="text" class="form-control" name="name" maxlength="50" value="<?php echo $name; ?>">
                </label>
                <p> <?php echo $nameErr;?></p>
                <br>
                <label>Product:</label>
                <br>
                
                <input type="checkbox" name="options[product][]" <?php if(in_array("create", $privileges["product"])) { echo 'checked="checked"';}?> value="create" />Create
                
                <input type="checkbox" name="options[product][]" <?php if(in_array("read", $privileges["product"])) {echo 'checked="checked"';}?> value="read" />Read

                <input type="checkbox" name="options[product][]"  <?php if(in_array("update", $privileges["product"])) {echo 'checked="checked"';}?> value="update" />Update

                
                <input type="checkbox" name="options[product][]" <?php if(in_array("delate", $privileges["product"])) {echo 'checked="checked"';}?> value="delete" />Delete
                <br>

                <br><br>
                <label>Catagory:</label>
                <br>
                
                <input type="checkbox" name="options[catagory][]" <?php if(in_array("create", $privileges["catagory"])) {echo 'checked="checked"';}?> value="create" />Create
                
                <input type="checkbox" name="options[catagory][]" <?php if(in_array("read", $privileges["catagory"])) {echo 'checked="checked"';}?> value="read" />Read
               
                <input type="checkbox" name="options[catagory][]"  <?php if(in_array("update", $privileges["catagory"])) {echo 'checked="checked"';}?> value="update" />Update
               
                <input type="checkbox" name="options[catagory][]"  <?php if(in_array("delete", $privileges["catagory"])) {echo 'checked="checked"';}?> value="delete" />Delete
                <br>

                <p> <?php echo $preErr;?></p>
                <br>
                <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">
              </form>
            </section>
        </div>

      </div>

<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../../dist/js/adminlte.min.js"></script>

</html>