<?php include('chklogin.php');include("conn.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ferro Deal</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo-mini.jpg" />
</head>
<body>
  <div class="container-scroller">
    <?php 
        include("header.php");
    //<!-- partial -->
        echo '<div class="container-fluid page-body-wrapper">';
        include("sidebar.php");
        if(!isset($_GET['page'])){
            include("content.php");
        }elseif(basename($_GET['page']) == 'userlist'){
            include("userlist.php");
        }elseif(basename($_GET['page']) == 'logout'){
            include("logout.php");
        }elseif(basename($_GET['page']) == 'stocklist'){
            include("stocklist.php");
        }elseif(basename($_GET['page']) == 'inventory'){
          include("inventory.php");
        }elseif(basename($_GET['page']) == 'inventorys'){
          include("inventorys.php");
        }elseif(basename($_GET['page']) == 'inventoryh'){
          include("inventoryhistory.php");
        }elseif(basename($_GET['page']) == 'inventoryo'){
          include("inventoryo.php");
        }elseif(basename($_GET['page']) == 'pending'){
          include("opending.php");
        }elseif(basename($_GET['page']) == 'confirm'){
          include("oconfirm.php");
        }elseif(basename($_GET['page']) == 'success'){
          include("osuccess.php");
        }elseif(basename($_GET['page']) == 'ocancle'){
          include("ocancle.php");
        }

    ?>
  </div>
  <!-- container-scroller -->
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

