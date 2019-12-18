<?php

    session_start();

    $id = $_SESSION["id"];

      if($_SESSION["id"]=="")
      {
            header("Location: ../../index.php");
      }

      include "../../errors.php";

      include "/databaseconnection.php";

      $type = $_SESSION["user_type"];

      $bool2=false;

      $bool3=false;

      $bool4=false;

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
      $_SESSION["temp_id"]=$id2;
      $sql = "select * from user_roles where role_id='$id2'";
      $rows = $conn->query($sql);
      $row = $rows->fetch_assoc();
      $ro_name=$row["role_name"];

      $sql3 = "select module_privileges from user_roles where role_id = $id2";

      $result2  = $conn->query($sql3);

      $row2 = $result2->fetch_assoc();

      $Privileges2 = unserialize($row2["module_privileges"]);

      $privileges = $Privileges2;

      $newArray2 = array_keys($Privileges2);

      if ($_SERVER["REQUEST_METHOD"] == "POST") 
      {
          if (empty($_POST["name"])) 
          {
            $nameErr = "Name is required";
          }
          else
          {
            $name = $_POST["name"];
            $ro_name=$name;
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

          $serializedArray = serialize($privileges);

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

            $name =htmlspecialchars($_POST['name']);

            $privileges=$_POST["options"];

            $serializedArray = serialize($privileges);

            $sql3 = "update user_roles set role_name= '$name',module_privileges= '$serializedArray'
             where role_id='$id2'";
            
            if ($conn->query($sql3) === TRUE) 
            {
              $error="";
              $_SESSION["user_role_update"]="The User Role Has Been Successfully Updated";
              header("Location: index.php");
            }
            else 
            {
              $error="The User Role Cannot Be Inserted";
              // echo "Error: " . $sql3 . "<br>" . $conn->error;
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
                      <li ><a href="user_role_management.php"><i class="fa fa-link"></i> <span>User role management</span></a></li>
                      <li><a href="index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
                      </li>
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
            </div>
            <section class="content container-fluid" style="text-align: center;">
<!--             <p><?php echo $error; ?></p>
 -->              <form method="post" style="margin-top: 50px;">
                <label>User Role  <input type="text" class="form-control" name="name" maxlength="50" value="<?php echo $ro_name; ?>">
                </label>
                <p> <?php echo $nameErr;?></p>
                <br>
<!--                         <?php for ($i=0; $i <= count($newArray2); $i++) 
                        { 
                            if($i==count($newArray2))
                            {
                              for($j=0;$j<count($newArray2);$j++)
                        { ?>
                            <label ><?php echo $newArray2[$j]; ?></label><br>
                        <?php  
                        $count=count($Privileges2[$newArray2[$j]]);
                        for($k=$count; $k<=$count; $k++) {  ?>

                            <input type="checkbox" name="options[<?php echo $newArray2[$j];?>][]"<?php
                            if(in_array('create',$Privileges2[$newArray2[$j]])){echo 'checked="checked"';}?>
                            class="langg" value="create">Create

                           <input type="checkbox" name="options[<?php echo $newArray2[$j];?>][]" <?php
                            if(in_array('read',$Privileges2[$newArray2[$j]])){echo 'checked="checked"';}?> class="langg" value="read">Read

                           <input type="checkbox" name="options[<?php echo $newArray2[$j];?>][]" <?php
                            if(in_array('update',$Privileges2[$newArray2[$j]])){echo 'checked="checked"';}?>  class="langg" value="update">Update

                            <input type="checkbox" name="options[<?php echo $newArray2[$j];?>][]" <?php
                            if(in_array('delete',$Privileges2[$newArray2[$j]])){echo 'checked="checked"';}?>  class="langg" value="delete">Delete
                            <br><br>

                        <?php }?>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?> -->
                <label>Product:</label>
                <br>
                
                <input type="checkbox" name="options[product][]" <?php if(in_array("create", $privileges["product"])) { echo 'checked="checked"';}?> value="create" />Create
                
                <input type="checkbox" name="options[product][]" <?php if(in_array("read", $privileges["product"])) {echo 'checked="checked"';}?> value="read" />Read

                <input type="checkbox" name="options[product][]"  <?php if(in_array("update", $privileges["product"])) {echo 'checked="checked"';}?> value="update" />Update

                
                <input type="checkbox" name="options[product][]" <?php if(in_array("delete", $privileges["product"])) {echo 'checked="checked"';}?> value="delete" />Delete
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
                <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">
                 <a href="index.php" class="btn btn-danger">Cancel</a>
              </form>
            </section>
        </div>

      </div>

    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../../../dist/js/adminlte.min.js"></script>

</html>