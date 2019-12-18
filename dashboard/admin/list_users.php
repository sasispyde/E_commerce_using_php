<?php

    session_start();

      $id= $_SESSION["id"];

      $type = $_SESSION["user_type"];

      include "../../errors.php";

      include "/databaseconnection.php";

      echo $_SESSION["blocked_error"];

      if($_SESSION["id"]=="")
      {
            header("Location: ../../index.php");
      }

      if($_SESSION["user_delete"]!="")
      {
        $success=$_SESSION["user_delete"];
        unset($_SESSION["user_delete"]);
      }

      if($_SESSION["user_insert_success"]!="")
      {
        $success=$_SESSION["user_insert_success"];
        unset($_SESSION["user_insert_success"]);
      }

      
      
      if($_SESSION["user_update_success"]!="")
      {
        $success=$_SESSION["user_update_success"];
        unset($_SESSION["user_update_success"]);
      }

    $id=$_SESSION["id"];

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

      $sql = "select module_privileges from user_roles where role_id = $id";

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

      $sqlForUsers="select * from users";

      $result2  = $conn->query($sqlForUsers);

      if($_GET['f'])
      {
         header("Location:"."../users/".$_GET['f']."/create.php");
      }
      $_GET['f']="";
      if($_GET['i'])
      {
         header("Location:"."../users/".$_GET['i']."/index.php");
      }

      if($_GET['did']!="")
      { 
          $id1=$_GET['did'];
          $sqlForDelete="delete from users where id = ".$id1;
          if ($conn->query($sqlForDelete) === TRUE) 
          {
            $error="";
            $_SESSION["user_delete"]="The User Has Been Deleted Successfully";
            header("Location:"."list_users.php");
          }
          else 
          {
            $error="The Role Cannot Be Deleted";
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

  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../../dist/css/style1.css">

  <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <script type="text/javascript">
        window.onload = function () { 
          setInterval(function(){
            document.getElementById("suc").innerHTML ="";
          },3000)
    }

      var myRoomNumber;

      $('#ddata').click(function() {
         myRoomNumber = $(this).attr('data-id'); 
         alert(myRoomNumber);
      });


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
            <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>           
            </div>
            <section class="content container-fluid">
<!--             <p style="color: red;font-size: 17px;"><?php echo $error; ?></p>
            <p style="color: green;" id="suc"><?php echo $success; ?></p> -->
                 <table class="table table-striped table-dark table-bordered">
                      <thead>
                          <tr>
                             <th >User Name</th>
                             <th >User Email</th>
                             <th>User Role</th>
                             <th >User Status</th>
                             <th >Edit</th>
                             <th >Delete</th>
                         </tr>
                      </thead>
                      <tbody>

                      <?php while($row = $result2->fetch_assoc()) {
                                  $role=$row["user_role_id"];
                                  $sqlForFindUserRole="select role_name from user_roles where role_id=$role";
                                  $res=$conn->query($sqlForFindUserRole);
                                  $res2=$res->fetch_assoc();
                       ?>
                          <tr>
                            <td>
                             <?php 
                                  echo ucfirst($row["user_name"]);
                             ?>
                            </td>
                            <td>
                             <?php 
                                  echo ucfirst($row["user_email"]);
                             ?>
                            </td>
                            <td>
                             <?php 
                                  echo ucfirst($res2["role_name"]);
                             ?>
                            </td>
                             <?php if($row["user_status"]=="A"){ ?>
                                  <td style="color: green"><?php echo ucfirst("active"); ?></td>   
                             <?php } else { ?>
                                  <td style="color: red"><?php echo ucfirst("blocked"); ?></td>
                             <?php } ?>
                            <td>
                                  <a href="userupdate.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Edit</a>
                            </td>
                            <td>                                  
                                  <a  data-toggle="modal" data-id="<?php echo $row["id"]; ?>" data-target="#myModal<?php echo $row["id"]; ?>" id="ddata" class="btn btn-danger" >Delete</a>
 <!--                                  <a href="?did=<?php echo $row['id'] ?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger">Delete</a> -->
                                <div class="modal fade" id="myModal<?php echo $row["id"]; ?>" role="dialog">
                                  <div class="modal-dialog">
                                  
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Delete User</h4>
                                      </div>
                                      <div class="modal-body">
                                        <h3>Do You Want To Delete The User</h3>
                                      </div>
                                      <div class="modal-footer">
                                        <a href="?did=<?php echo $row['id'];?>" class="btn btn-danger" name="del">Delete</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                    
                                  </div> 
                            </td>
                           </tr>
                            <?php } ?>
                       </tbody>
                      </table>                                     
            </section>
        </div>
      </div>
</body>


<script src="../../bower_components/jquery/dist/jquery.min.js"></script>

<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../../dist/js/adminlte.min.js"></script>

</html>