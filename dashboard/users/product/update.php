<?php

    session_start();

    $id = $_SESSION["id"];

      if($_SESSION["id"]=="")
      {
            header("Location: ../../../index.php");
      }

    include "../../../errors.php";

    include "/databaseconnection.php";

      $type = $_SESSION["user_type"];

      $bool2=false;
      $bool3=false;
      $bool4=false;

      $sql = "select module_privileges from user_roles where role_id = $id";

      $country ="selected category";

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

     if($_SESSION["user"]=="" || $_SESSION["userid"]=="")
         {
            header("Location: ../../index.php");
         }
      if(in_array("update", $Privileges["product"]))
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

      $id = (int)$_GET['id'];
      $sql = "select * from product where product_id='$id'";
      $rows = $conn->query($sql);
      $row = $rows->fetch_assoc();

      $product_name = $row['product_name'];
      $price = $row['price'];
      $product_description = $row['product_description'];

      $id_ref=$row["category_id"];
      $sqlForSelect="SELECT category_name FROM category where id ='$id_ref'";
      $res = $conn->query($sqlForSelect);
      $res=$res->fetch_assoc();
      $name4=$res["category_name"];

      $cid=$row["category_id"];

      $sqlforcategory="select * from category where id='$cid'";
      $r = $conn->query($sqlforcategory);
      $res=($r->fetch_assoc());

      if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {

              if (empty($_POST["task"])) 
              {
                $nameEr = "Name is required";
              }
              else
              {
                  $task = $_POST["task"];

                  $product_name = $task;
                  if (!preg_match("/^[a-zA-Z ]*$/",$task) || strlen($task)>50) 
                  {
                    if(strlen($task)>50)
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

              if (empty($_POST["price"])) 
              {
                $priceEr = "Product Price is Required";
              }
             else 
             {
                $price = $_POST["price"];
                if (!preg_match('/^[0-9]*$/',$price)) 
                {
                  $priceErr = "Enter valid Product Price";
                }
                else
                {
                  $priceErr = "";
                  $bool3=true;
                }
            }

            if (empty($_POST["description"])) 
            {
                $descriptionErr = "Product Description is Required";
            } 
            else 
            {
              $description = $_POST["description"];
              $product_description=$description;
              if (strlen($description)>250)
              {
                  $descriptionErr = "The Description Should Be Less Then 250 Charecters ";
              }
              else
              {
                  $descriptionErr = "";
                  $bool4=true;
              }

            }

            $user=$_POST["cat"];
            if (empty($_POST["cat"]))
            {
              $nameErr = "Please Select The User_Role";
            } 
            else 
            {
              $u = $_POST["cat"];
              $id_ref=$_POST["cat"];
              $sqlForSelect="SELECT category_name FROM category where id ='$id_ref'";
              $res = $conn->query($sqlForSelect);
              $res=$res->fetch_assoc();
              $name4=$res["category_name"];
              $bool1=true;
              $nameErr="";
            }


      if ($bool2&&$bool3&&$bool4) 
      {
        $task = htmlspecialchars($_POST['task']);
        $task1 = htmlspecialchars($_POST['price']);
        $task2 = htmlspecialchars($_POST['description']);
        $task3 = $_POST['cat'];

      $sql3 = "update product set product_name= '$task',price= '$task1',product_description= '$task2',category_id= $task3 where product_id='$id'";
        // $conn->query($sql2);
            if ($conn->query($sql3) === TRUE) 
            {
              $error="";
              $_SESSION["product_update_success"]="The Product Has Been Updated Successfully";
              header('Location: index.php');
            }
            else 
            {
              $error="The Product Cannot Be Updated";
            }
      }
    }
      $sql2="SELECT * FROM category";
      $result2 = $conn->query($sql2);

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
                      <li><a href="../../admin/user_role_management.php"><i class="fa fa-link"></i> <span>User role management</span></a></li>
                      <li><a href="../../admin/index.php"><i class="fa fa-link"></i> <span>List User Roles</span></a></li>
                      <li><a href="../../admin/user_management.php"><i class="fa fa-link"></i> <span>User management</span></a></li>
                      <li><a href="../../admin/list_users.php"><i class="fa fa-link"></i> <span>List User</span></a></li>
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
            <!-- <p style="color: green;text-align: center;padding: 10px;" id="suc"><?php echo $success; ?></p>            -->
            </div>
            <section class="content container-fluid" style="text-align: center;">
            <!-- <p><?php echo $error; ?></p> -->
                          <form method="post">

                          <div class="form-group">
                            <label for="task">Product Name
                            <input type="text" name="task" maxlength="50" class="form-control" value="<?php echo $product_name; ?>" ></label>
                            <p> <?php echo $nameEr;?></p><br>
                            <label for="task">Price
                            <input type="text" name="price" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="8" value="<?php echo $price; ?>" ></label>
                            <p> <?php echo $priceEr;?></p><br>
                            <label for="task">Product Description
                            <br>
                            <textarea style="width: 217px;" maxlength="250" class="form-control" name="description"><?php echo $product_description;  ?></textarea>
                            </label>
                            <p> <?php echo $descriptionErr;?></p><br>
                            <label>Category Name</label><br>
                          <select style="color: black;text-align-last: center;" id="user_role" name="cat">

                             <!--  <option value="<?php echo $res["id"]; ?>" ><?php echo $res["category_name"] ?></option> -->
                             <option value="<?php echo $id_ref; ?>"><?php echo $name4; ?></option>
                              <?php while($rs=$result2->fetch_assoc()){ if($id_ref!=$rs["id"]){?>
                              <option value="<?php echo $rs["id"]; ?>" ><?php echo $rs["category_name"] ?></option>
                              <?php }}?>

                            </select>
                            <p> <?php echo $nameErr;?></p>
                          </div>
                          <input type="submit" class="btn btn-success" name="submit" value="Update">&nbsp;
                          <a href="index.php" class="btn btn-danger">Cancel</a>
                        </form>
            </section>
        </div>

      </div>

    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../../../dist/js/adminlte.min.js"></script>

</html>