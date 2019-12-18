<?php

    session_start();

     if($_SESSION["user"]=="" || $_SESSION["user_type"]=="")
         {
            header("Location: ../../index.php");
         }

?>

<!-- <!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Dashboard</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="dist/css/style1.css">

  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">

        <header class="main-header"> -->

          <!-- Header Navbar -->
<!--         <nav class="navbar navbar-static-top" role="navigation">
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
                        <a href="logout.php" class="label-danger text-center btn" style="width: 150px;">Logout</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
          <aside class="main-sidebar"> -->

          <?php if($_SESSION["user_type"]=="admin"){ ?>

          <?php header("Location: /dashboard/admin/index.php"); }

          else
          {
              header("Location: /dashboard/users/index.php");
          }

          ?>
<!-- 

          </aside>

        <div class="content-wrapper">
            <section class="content container-fluid" style="text-align: center;">
              Welcome to Dashboard
            </section>
        </div>

      </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="dist/js/adminlte.min.js"></script>

</html> -->