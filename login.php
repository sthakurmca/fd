<?php
    session_start();
    if(isset($_SESSION['fname'])){
        header('location:index.php');
    }
    $errormsg = "";
    if(isset($_POST['login'])){
        if( (trim($_POST['uname']) != "") && (trim($_POST['password']) != "") ){

            include("conn.php");
            $sql = "SELECT user_fname,user_id,user_type,user_profileimage FROM user WHERE user_type IN ('Super Admin','Admin', 'SCM') AND user_status = 1 AND ( (user_email = '".$_POST['uname']."') OR (user_phone = '".$_POST['uname']."') ) AND user_password = '".$_POST['password']."'";
            $result = $conn->query($sql); 

            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                $_SESSION['userid'] = $row['user_id'];
                $_SESSION['fname'] = $row['user_fname'];
                $_SESSION['type'] = $row['user_type'];
                $_SESSION['profileimage'] = $row['user_profileimage'];
                header('location:index.php');
            } else {
                $errormsg = "Invalid Username/Password";
            }

        }else{ 
            $errormsg = "Please enter Username/Password";
        }
    }
    
?>
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
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="images/fd.jpg" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <?php if(trim($errormsg) != ""){ echo"<code>Invalid Username/Password</code>";}?>
              <form class="pt-3" name="login" id="login" action="" method="POST" enctype="multipart/form-data"> 
                <div class="form-group">
                  <input type="text" name="uname" id="uname" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="login" value="SIGN IN">
                </div>
                <!--<div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Create</a>
                </div>-->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
