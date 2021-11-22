    
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <!--<div class="col-md-12 grid-margin stretch-card">-->
            <div class="col-lg-12 grid-margin stretch-card">
            <?php
            $formerror = "";
            $uploadOk = 2;
            if(isset($_POST['submit'])){
              if(trim($_POST['fname']) == ""){
                $formerror = $formerror.", Full name";
              }if(trim($_POST['phone']) == ""){
                $formerror = $formerror.", Phone Number";
              }if(trim($_POST['password']) == ""){
                $formerror = $formerror.", Password";
              }if(trim($_POST['email']) == ""){
                $formerror = $formerror.", Email";
              }
              if(trim($_POST['gst']) == ""){
                $formerror = $formerror.", GST Number";
              }

              if(isset($_GET['id'])){
                $sqlemail = "SELECT user_id FROM user WHERE user_email = '".$_POST['email']."'";
                $result = $conn->query($sqlemail); 

                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  if($_GET['id'] != $row['user_id']){
                    $formerror = $formerror.", This Email is already taken.";
                  }
                }
                $sqlphone = "SELECT user_id FROM user WHERE user_phone =".$_POST['phone'];
                $result = $conn->query($sqlphone); 

                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  if($_GET['id'] != $row['user_id']){
                    $formerror = $formerror.", This Phone Number is already taken.";
                  }
                }
              }else{
                $sqlemail = "SELECT user_id FROM user WHERE user_email = '".$_POST['email']."'";
                $result = $conn->query($sqlemail); 

                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $formerror = $formerror.", This Email is already taken.";
                }
                $sqlphone = "SELECT user_id FROM user WHERE user_phone =".$_POST['phone'];
                $result = $conn->query($sqlphone); 

                if ($result->num_rows > 0) {
                  $formerror = $formerror.", This Phone Number is already taken.";
                }
              }

              $fname = $_POST['fname'];
              $type = $_POST['type'];
              $phone = $_POST['phone'];
              $email = $_POST['email'];
              $gst = $_POST['gst'];
              $password = $_POST['password'];
              if( (isset($_FILES["photo"]["name"])) && (trim($_FILES["photo"]["name"]) != "") ){
                $target_dir = "userimages/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                $filename = basename($_FILES["photo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if($check !== false) {
                  $uploadOk = 1;
                } else {
                  $uploadOk = 0;
                }
              }

              if(trim($formerror) != ""){
                $formerror = "Please enter ".ltrim($formerror,",").".";
              }
              if($uploadOk == 0){
                if(trim($formerror) == ""){
                  $formerror = $formerror . "Please upload proper image.";
                }else{
                  $formerror = $formerror . "<br>Please upload proper image.";
                }
              }
            }
            if(isset($_GET['a'])){//add/edit of user
              if($_GET['a'] == 1){//for edit

                if(!(isset($_POST['submit']))){//Come first time
                  $sql = "SELECT * FROM user WHERE user_id =".$_GET['id'];
                  $result = $conn->query($sql); 

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $fname = $row['user_fname'];
                    $type = $row['user_type'];
                    $phone = $row['user_phone'];
                    $email = $row['user_email'];
                    $password = $row['user_password'];
                    $gst = $row['user_gst'];
                  }
                }else{//After post

                  if(trim($formerror) == ""){

                    $sqluser = "UPDATE user SET 
                    user_fname = '".$fname."', user_password = '".$password."', user_email = '".$email."', user_phone = '".$phone."', user_gst = '".$gst."', user_type = '".$type."' 
                    WHERE user_id = ".$_GET['id'];
                    $conn->query($sqluser);
                    if($uploadOk == 1){
                      if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)){
                        $sqluserphoto = "UPDATE user SET user_profileimage = '".$filename."' WHERE user_id = ".$_GET['id'];
                        $conn->query($sqluserphoto);
                      }
                    }
                    echo "<script>window.location.href='index.php?page=userlist&m=User Updated.'</script>";
                    //header('location:index.php');

                  }

                }

              }elseif($_GET['a'] == 2){//for add

                if(!(isset($_POST['submit']))){
                  $fname = "";
                  $type = "";
                  $phone = "";
                  $email = "";
                  $gst = "";
                }elseif(trim($formerror) == ""){

                  if($type == 'Admin'){
                    $statusadmin = 1;
                  }else{
                    $statusadmin = 0;
                  }

                  $sqluser = "INSERT INTO user (user_fname, user_password, user_email, user_phone, user_gst, user_type, user_status, user_createdate)
                  VALUES ('".$fname."', '".$password."', '".$email."','".$phone."', '".$gst."', '".$type."', '".$statusadmin."', '".date('Y-m-d h:i:s')."')";
                  $conn->query($sqluser);
                  $last_id = $conn->insert_id;
                  //echo $uploadOk;die();
                  if($uploadOk == 1){
                    if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)){
                      $sqlphoto = "UPDATE user SET user_profileimage = '".$filename."' WHERE user_id = ".$last_id;
                      $conn->query($sqlphoto);
                    }
                  }
                  echo "<script>window.location.href='index.php?page=userlist&m=New user added.'</script>";
                }

              }
            ?>

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">User details</h4>
                  <?php if(trim($formerror) != ""){ echo"<code>".$formerror."</code>";}?>
                  <!--<p class="card-description">
                    Basic form elements
                  </p>-->
                  <form name="user" id="user" method="POST" action="index.php?a=<?php echo $_GET['a'];?><?php if(isset($_GET['id'])){echo "&id=".$_GET['id'];}?>&page=userlist" enctype="multipart/form-data" class="forms-sample">
                    
                    <div class="form-group">
                      <label>Full Name</label>
                      <input required type="text" value="<?php echo $fname;?>" class="form-control" placeholder="Name" name="fname" id="fname">
                    </div>
                    <div class="form-group">
                      <label>User Type</label>
                      <select name="type" id="type" class="js-example-basic-single w-100">
                        <option value="Dealer" <?php if($type == "Dealer"){echo "selected";}?>>Dealer</option>
                        <option value="Consumer" <?php if($type == "Consumer"){echo "selected";}?>>Consumer</option>
                        <option value="Project" <?php if($type == "Project"){echo "selected";}?>>Project</option>
                        <option value="Admin" <?php if($type == "Admin"){echo "selected";}?>>Admin</option>
                        <option value="SCM" <?php if($type == "SCM"){echo "selected";}?>>SCM</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input required type="number" value="<?php echo $phone;?>" class="form-control"  placeholder="Phone" name="phone" id="phone">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input required type="password" value="<?php echo $password;?>" class="form-control"  placeholder="Password" name="password" id="password">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input required type="email" value="<?php echo $email;?>" class="form-control"  placeholder="Email" name="email" id="email">
                    </div>
                    <div class="form-group">
                      <label>GST Number</label>
                      <input required type="gst" value="<?php echo $gst;?>" class="form-control"  placeholder="GST" name="gst" id="email">
                    </div>
                    <div class="form-group">
                      <label>Photo upload</label><code>leave it blank if you don't want to change it</code>
                      <input type="file" name="photo" id="photo">
                      <!---<div class="input-group col-xs-12">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>-->
                    </div>
                    <input type="submit" class="btn btn-primary mr-2" value="Update" name="submit" id="submit" />
                    <input type="reset" class="btn btn-light" value="Reset" name="reset" id="reset" />
                  </form>
                </div>
              </div>

            <?php
            }else{//Show list of user
            ?>
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User List</h4>
                    <?php
                      if(isset($_GET['m'])){
                        echo "<code>".$_GET['m']."</code>";
                      }
                    ?>
                    <?php if($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'Super Admin'){ ?><a href='index.php?a=2&page=userlist'><i class="mdi mdi-plus"></i></a><?php }?>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>User</th>
                            <th>Name</th>
                            <th>Type</th>
                            <!--<th>Username</th>-->
                            <th>Phone</th>
                            <th>Email</th>
                            <th>GST</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql); 

    $errormsg = "";
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()){
        // output data of each row
                          echo"<tr>
                              <td class='py-1'><img src='userimages/".$row['user_profileimage']."' alt='image'/></td>
                              <td>".$row['user_fname']."</td>
                              <td>".$row['user_type']."</td>
                              <td>".$row['user_phone']."</td>
                              <td>".$row['user_email']."</td>
                              <td>".$row['user_gst']."</td>";
?>
                              <td>
                              <?php
                              if($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'Super Admin'){ 
                                if($row['user_type'] != 'Super Admin'){
                                  if($row['user_status'] == 0){
                              ?>
                                      <a href="changeuser.php?s=1&a=0&id=<?php echo $row['user_id'];?>" onclick="return confirm('Are you sure you want to active this user?');">
                                      <i class="mdi mdi-backup-restore"></i>
                                      </a>
                                  <?php }else{?>
                                      <a href="changeuser.php?s=0&a=0&id=<?php echo $row['user_id'];?>" onclick="return confirm('Are you sure you want to remove this user?');">
                                      <i class='mdi mdi-delete'></i>
                                      </a>
                                  <?php }
                              ?>
                                
                                &nbsp;&nbsp;&nbsp;
                              <?php }?>
                              <a href="?page=userlist&a=1&id=<?php echo $row['user_id'];?>"<i class='mdi mdi-pencil'></i></a>
                            <?php }?>  
                            </td>
<?php                         echo"</tr>";
      }
    } else {
        echo"<tr><td rowspan='8'>No User Found.</td></tr>";
    }
?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

<?php       }?>

            </div>
            <!--</div>-->
          </div>
        </div>
        <!-- content-wrapper ends -->
        <?php include("footer.php");?>
    </div>
      <!-- main-panel ends -->