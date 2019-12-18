<?php

    session_start();

    $id= $_SESSION["id"];

    $userid=$_SESSION["userid"];

      if($_SESSION["id"]=="")
      {
            header("Location: ../../../../index.php");
      }

    include "../../../errors.php";

    include "/databaseconnection.php";

      $type = $_SESSION["user_type"];

      $bool1=false;
      $bool2=false;
      $bool3=false;
      $bool4=false;
      $id_ref ="";
      $cat_name="Select The Category";

      $sql = "select module_privileges from user_roles where role_id = $id";

      $result  = $conn->query($sql);

      $row = $result->fetch_assoc();

      $Privileges = unserialize($row["module_privileges"]);

      $newArray = array_keys($Privileges);

     if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
      {
            header("Location: ../../index.php");
      }
      if(in_array("create", $Privileges["product"]))
      {

      }
      else
      {
        $_SESSION["error"]="Error...  You Hava No Permission To Access This Page";
        header("Location: ../index.php");
      }

      if($_GET['yu'])
      {
         header("Location:"."../".$_GET['yu']."/create.php");

      }

      if($_GET['hu'])
      {
         header("Location:"."../".$_GET['hu']."/index.php");
      }


      if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {

              $category_id=$_POST["category_id"];
              if (empty($_POST["category_id"]))
              {
                $idErr = "Please Select The User Role";
              } 
              else 
              {
                $category_id = $_POST["category_id"];
                $id_ref=$category_id;

                $sqlForSelect="SELECT category_name FROM category where id ='$id_ref'";

                $res = $conn->query($sqlForSelect);

                $res=$res->fetch_assoc();

                $cat_name=$res["category_name"];
                $bool1=true;
                $idErr="";
              }


              if (empty($_POST["productname"])) 
              {
                $nameEr = "Name is Required";
              }
              else
              {
                  $productname = $_POST["productname"];
                  if (!preg_match("/^[a-zA-Z ]*$/",$productname) || strlen($productname)>50) 
                  {
                    if(strlen($productname)>50)
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

            if($bool1&&$bool2&&$bool3&&$bool4)
            {
                  $sql2="insert into product (product_name,price,product_description,category_id,created_user_id)values('$productname',$price,'$description',$category_id,$userid)";
                  if ($conn->query($sql2) === TRUE) 
                  {
                    $error="";
                    $_SESSION["product_create_success"]="The Product Has Been Inserted Successfully";
                    header("Location: index.php");
                  }
                  else 
                  {
                    $error="The Product Cannot Be Inserted Due To Some Error";
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

  <style type="text/css">
    textarea
    {
      width: 300px;
    }
    p
    {
      color:red;
    }
    select
    {
      width: 214px;
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
                             <ul class="treeview-menu">
                        <?php  
                        $count=count($Privileges[$newArray[$j]]);
                        for($k=0; $k<$count; $k++) {  ?>
                              <?php if($Privileges[$newArray[$j]][$k]=="create") {?>
                              <li><a  href="?yu=<?php echo $newArray[$j]; ?>">Create</a></li>
                              <?php }?>
                              <?php if($Privileges[$newArray[$j]][$k]=="read") {?>
                              <li><a href="?hu=<?php echo $newArray[$j]; ?>">List</a></li>
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
              <form style="margin-top: 50px;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label>Product Name
                <input class="form-control" type="text" maxlength="50" name="productname" value=<?php echo $productname; ?>></label>
                <p> <?php echo $nameEr;?></p><br>
                <label>Price
                <input class="form-control" type="text" maxlength="8"  name="price" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " value="<?php echo $price; ?>"></label>
                <p> <?php echo $priceEr;?></p><br>
                <label>Product Description
                <textarea style="width: 217px;" maxlength="250" class="form-control" name="description"><?php echo $description; ?></textarea></label>
                <p> <?php echo $descriptionErr;?></p><br>
                <?php 
                    $sql="SELECT * FROM category";
                    $result = $conn->query($sql);
                ?>
                <label>Category Name</label><br>
                <select style="color: black;text-align-last: center;" id="user_role" name="category_id">
                    <option value=<?php echo $id_ref ?>><?php echo $cat_name; ?></option>
                   <?php while($rs=$result->fetch_assoc()){ if($id_ref!=$rs["id"]){?>
                        <option value="<?php echo $rs["id"]; ?>" ><?php echo $rs["category_name"] ?></option>
                   <?php }}?>
                </select>
                <br>
                <p> <?php echo $idErr;?></p>
                <br>
                <input type="submit" class="btn btn-primary" name="submit">
              </form>
            </section>
        </div>

      </div>

    <script src="../../../bower_components/jquery/dist/jquery.min.js"></script>

    <script src="../../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../../../dist/js/adminlte.min.js"></script>

</html>