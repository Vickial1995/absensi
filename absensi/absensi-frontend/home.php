<?php
session_start();
if(!isset($_SESSION['username'])){
  header('location:index.php');
}

?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Absensi Anytime Fitness</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin=""
    />
<!--Ini JS-->
    <script
      src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
      integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
      crossorigin=""></script>
  <style>
    .red-bg{
      background-color: red !important;
      color: white;
    }

    .green-bg{
      background-color: #43987E !important;
      color: white;
    }


    table.formatHTML5 {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      color: #606060;
    }

    /*** table's tbody section, odd rows style ***/
    table.formatHTML5 tbody tr:nth-child(odd) {
      background-color: #fafafa;
    }

    /*** hover effect to table's tbody odd rows ***/
    table.formatHTML5 tbody tr:nth-child(odd):hover {
      cursor: pointer;
      /* add gradient */
      background-color: #808080;
      color: #dadada;
    }

    /*** table's tbody section, even rows style ***/
    table.formatHTML5 tbody tr:nth-child(even) {
      background-color: #efefef;
    }

    /*** hover effect to apply to table's tbody section, even rows ***/
    table.formatHTML5 tbody tr:nth-child(even):hover {
      cursor: pointer;
      /* add gradient */
      background-color: #808080;
      color: #dadada;
    }

    table.formatHTML5 tr.selected {
      background-color: #0099ff !important;
      color: #fff;
      vertical-align: middle;
      padding: 1.5em;
    }

    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
    }

    .panel-heading h4 {
      color: white;
    }

    /* Style the tab */
    .tab {
      float: left;
      border: 1px solid #ccc;
      background-color: #f1f1f1;
      width: 20%;
      height: 300px;
    }

    /* Style the buttons inside the tab */
    .tab button {
      display: block;
      background-color: inherit;
      color: black;
      padding: 22px 16px;
      width: 100%;
      border: none;
      outline: none;
      text-align: left;
      cursor: pointer;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current "tab button" class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      float: left;
      padding: 0px 12px;
      border: 1px solid #ccc;
      width: 70%;
      border-left: none;
      height: 300px;
    }

    table.formatHTML5 {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      color: #606060;
    }

    /*** table's tbody section, odd rows style ***/
    table.formatHTML5 tbody tr:nth-child(odd) {
      background-color: #fafafa;
    }

    /*** hover effect to table's tbody odd rows ***/
    table.formatHTML5 tbody tr:nth-child(odd):hover {
      cursor: pointer;
      /* add gradient */
      background-color: #808080;
      color: #dadada;
    }

    /*** table's tbody section, even rows style ***/
    table.formatHTML5 tbody tr:nth-child(even) {
      background-color: #efefef;
    }

    /*** hover effect to apply to table's tbody section, even rows ***/
    table.formatHTML5 tbody tr:nth-child(even):hover {
      cursor: pointer;
      /* add gradient */
      background-color: #808080;
      color: #dadada;
    }

    table.formatHTML5 tr.selected {
      background-color: #0099ff !important;
      color: #fff;
      vertical-align: middle;
      padding: 1.5em;
    }

    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -1px;
    }

    .panel-heading h4 {
      color: white;
    }


    .tabs-left,
    .tabs-right {
      border-bottom: none;
      padding-top: 2px;
    }

    .tabs-left {
      border-right: 1px solid #ddd;
    }

    .tabs-right {
      border-left: 1px solid #ddd;
    }

    .tabs-left>li,
    .tabs-right>li {
      float: none;
      margin-bottom: 2px;
    }

    .tabs-left>li {
      margin-right: -1px;
    }

    .tabs-right>li {
      margin-left: -1px;
    }

    .tabs-left>li.active>a,
    .tabs-left>li.active>a:hover,
    .tabs-left>li.active>a:focus {
      border-bottom-color: #ddd !important;
      border-right-color: transparent !important;
      background-color: #00a65a !important;
      color: white;
    }

    .tabs-right>li.active>a,
    .tabs-right>li.active>a:hover,
    .tabs-right>li.active>a:focus {
      border-bottom: 1px solid #ddd !important;
      border-left-color: transparent !important;
    }

    .tabs-left>li>a {
      border-radius: 4px 0 0 4px;
      margin-right: 0;
      display: block;

    }

    .tabs-right>li>a {
      border-radius: 0 4px 4px 0;
      margin-right: 0;
    }

    #overlay {
      position: fixed;
      top: 0;
      z-index: 2000;
      width: 100%;
      height: 100%;
      display: none;
      background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(359deg);
      }
    }

    .is-hide {
      display: none;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="index3.html" class="navbar-brand">
        <img src="assets/af_logo.png" alt="AdminLTE Logo" class="brand-image">
        
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a href="home.php" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#pengajuan" class="nav-link nav-control">Absensi</a>
          </li>

          <li class="nav-item">
            <a href="#report" class="nav-link nav-control">Report</a>
          </li>

          
          
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Setting</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#user" class="nav-control dropdown-item">User</a></li>
              
            </ul>
          </li>

         
        </ul>
        
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        

        <li class="nav-item">
          <a class="nav-link" href="logout.php">
            <i class="fas fa-power-off"></i>
            
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Selamat Datang <?=$_SESSION['username']?> <small><?=date('Y-m-d')?></small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#" >Page</a></li>
              <li class="breadcrumb-item"><a href="#" id="page">Home</a></li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div id="contentApp">
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->

<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function () {
        $(".nav-control").click(function () {
            console.log('coeg')
            var menu = $(this).attr('href');
            menu = menu.replace("#","");
            changePage(menu, "page/" + menu + "/" + menu + ".php");
        });

        function changePageListener() {
          var url = document.location.toString();
          if (url.match('#')) {
            //alert("coeg");

            var menu = url.split('#')[1];
            console.log(url);
            if (menu.includes("-")) {
              if (url.includes("?")) {
                console.log("masuk sini");
                var fragment = url.split("?")[1].split("#")[0];
                changePage(menu, "page/" + menu.split("-")[0] + "/" + menu.split("-")[1] + "/" + menu.split("-")[1] +
                  ".php?" + fragment);
              } else {
                changePage(menu, "page/" + menu.split("-")[0] + "/" + menu.split("-")[1] + "/" + menu.split("-")[1] +
                  ".php");
              }

            } else if (url.includes("?")) {
              console.log("masuk sini");
              var fragment = url.split("?")[1].split("#")[0];
              changePage(menu, "page/" + menu + "/" + menu +
                ".php?" + fragment);
            } else if (menu != "") {
              changePage(menu, "page/" + menu + "/" + menu + ".php");
            }
          } else {
            changePage('dashboard', 'page/dashboard/dashboard.php');
          }
        }

        function changePage(menu, page) {
            console.log('change page');
          $('.sidemenu').removeClass('active');
          $("[page=" + menu + "]").addClass("active");
         
          $("#contentApp").load(page, function () {
            console.log('coeg')
            $("#page").html(menu)
            
            //animateCSS('#contentapp', 'bounceInDown')
            
          })
          //window.location.href = "#" + menu;
          
        }

        changePageListener();
    });
</script>

</body>
</html>
