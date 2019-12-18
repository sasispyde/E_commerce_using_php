<?php

      session_start();

      $id = $_SESSION["id"];

      $userid=$_SESSION["userid"];

        if($_SESSION["id"]=="")
        {
              header("Location: ../../../index.php");
        }

      include "../../../errors.php";

      include "/databaseconnection.php";

      if( $_SESSION["category_create_success"]!="")
      {
        $success= $_SESSION["category_create_success"];
        unset( $_SESSION["category_create_success"]);
      }

      if( $_SESSION["category_delete_success"]!="")
      {
        $success= $_SESSION["category_delete_success"];
        unset( $_SESSION["category_delete_success"]);
      }

      if( $_SESSION["category_update_success"]!="")
      {
        $success= $_SESSION["category_update_success"];
        unset( $_SESSION["category_update_success"]);
      }

      $type = $_SESSION["user_type"];

      $new_type=$type;

      $bool=false;

      $conn = new mysqli($servername, $username, $password,"SASI");

      $sql = "select module_privileges from user_roles where role_id = $id";

      if($new_type=='admin')
      {
        $sql2 = "select * from category";
      }
      else
      {
        $sql2 = "select * from category where created_user_id=$userid";
      }

      $result2=$conn->query($sql2);

      // $associate = $result2->fetch_assoc();

      print_r($associate);

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

     if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
         {
            header("Location: ../../index.php");
         }

      if(in_array("read", $Privileges["catagory"]))
      {

      }
      else
      {
        $_SESSION["error"]="Error...  You Hava No Permission To Access This Page";
        header("Location: ../index.php");
      }
      
      if($_GET['f'])
      {
         header("Location:"."../".$_GET['f']."/create.php");
      }
      if($_GET['h'])
      {
         header("Location:"."../".$_GET['h']."/index.php");
      }

      if($_GET['did']!="")
      { 
          $id1=$_GET['did'];
          $sqlForDelete="delete from category where id = ".$id1;
          if ($conn->query($sqlForDelete) === TRUE) 
          {
            $error="";
            $_SESSION["category_delete_success"]="The Category Has Been Deleted Successfully";
            header("Location:"."../catagory/index.php");
          }
          else 
          {
            $error="The Category Is Not Deleted Due To Some Error...";
          // echo "Error: " . $sqlForDelete  . $conn->error;
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

    <script type="text/javascript">
        window.onload = function () { 
          setInterval(function(){
            document.getElementById("suc").innerHTML ="";
          },3000)
    }
  </script>

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
              <ul class="sidebar-menu" data-widget="tree"">
                <!-- <li class="header" style="color: white;text-align: center;font-size: 20px;">Options</li> -->
                            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>User Role Management</span>
                              <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                             </a>
                             <ul class="treeview-menu" >
                                <li ><a href="../../admin/user_role_management.php"><i class="fa fa-link"></i> <span>Create</span></a></li>
                                <li><a href="../../admin/index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a>
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
                                  <li><a href="../../admin/user_management.php"><i class="fa fa-link"></i> <span>Create User</span></a></li>
                                  <li><a href="../../admin/list_users.php"><i class="fa fa-link"></i> <span>List User</span></a>
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
            <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>           
            </div>
            <section class="content container-fluid">
                <table class="table table-striped table-dark table-bordered">
                  <thead>
                      <tr>
                         <th >Category Name</th>
                          <?php if($new_type=="admin"){ ?>
                         <th >Created By</th>
                         <?php }?>
                         <?php if(in_array("update",$Privileges["catagory"])) {?>
                         <th >Edit</th>
                         <?php }?>
                         <?php if(in_array("delete",$Privileges["catagory"])){ ?>
                         <th >Delete</th>
                         <?php }?>

                     </tr>
                  </thead>
                  <tbody>

                  <?php while($row = $result2->fetch_assoc()) {

                          if($new_type=="admin")
                          {
                            $role=$row["created_user_id"];
                            $sqlForFindUserName="select user_name from users where id=$role";
                            $res=$conn->query($sqlForFindUserName);
                            $res2=$res->fetch_assoc();
                          }
                   ?>
                      <tr>
                        <td>
                         <?php 
                              echo ucfirst($row["category_name"]);
                         ?>
                        </td>
                        <?php if($new_type=="admin"){ ?>
                        <td>
                         <?php 
                         echo ucfirst($res2["user_name"]); ?>
                        </td>
                        <?php } ?>

                        <td>
                          <?php 
                          if($key!="id")
                          {
                            if(in_array("update",$Privileges["catagory"]))
                            { ?>
                              <a href="update.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Edit</a>
                          <?php } }?>
                        </td>
                        <td>
                          <?php 
                          if($key!="id")
                          {
                            if(in_array("delete",$Privileges["catagory"]))
                            { ?>

                                <a  data-toggle="modal" data-id="<?php echo $row["id"]; ?>" data-target="#myModal<?php echo $row["id"]; ?>" id="ddata" class="btn btn-danger" >Delete</a>
             <!--                                  <a href="?did=<?php echo $row['id'] ?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger">Delete</a> -->
                                    <div class="modal fade" id="myModal<?php echo $row["id"]; ?>" role="dialog">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Delete Category</h4>
                                         </div>
                                        <div class="modal-body">
                                          <h3>Do You Want To Delete The Category</h3>
                                        </div>
                                        <div class="modal-footer">
                                          <a href="?did=<?php echo $row['id'];?>" class="btn btn-danger" name="del">Delete</a>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>  
                                    </div> 
                          <?php } }?>
                        </td>
                       </tr>
                        <?php } ?>
                   </tbody>
                  </table>
            </section>
        </div>

      </div>

    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../../../dist/js/adminlte.min.js"></script>

</html>