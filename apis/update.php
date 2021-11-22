<?php
  include("../conn.php");
  //$_POST['Email'] = "vidfvdfrat@test.com";
  //$email = $_POST['Email'];
  //$_POST['Phone number'] = "123456789";
  //$phone = $_POST['Phone number'];
  $_POST['Name'] = "cvascascasccdsv";
  $fname = $_POST['Name'];
  $_POST['Firm name'] = "virat@test.com";
  $firmname = $_POST['Firm name'];
  $_POST['GST number'] = "123456";
  $gst = $_POST['GST number'];
  $_POST['Customer type'] = "123456";
  $type = $_POST['Customer type'];
  $_POST['Password'] = "123456";
  $password = $_POST['Password'];
  $_POST['TAN number'] = "123456";
  $tannumber = $_POST['TAN number'];
  $_POST['Email'] = "scdscsd@test.com";
  $email = $_POST['Email'];

  $sqldup = "SELECT * FROM user WHERE user_email = '".$email."'";
  $resultdup = $conn->query($sqldup); 

  if ($resultdup->num_rows > 0) {

    $sqluser = "UPDATE user SET 
    user_fname = '".$fname."', user_password = '".$password."', user_gst = '".$gst."', user_type = '".$type."', user_tannumber = '".$tannumber."', user_firmname = '".$firmname."' 
    WHERE user_email = '".$email."'";
    $conn->query($sqluser);
    $result = $conn->query($sqluser); 

    $row['status'] = "Yes";
    $row = json_encode($row);

  }else{
    $row['status'] = "No";
    $row = json_encode($row);
  }
  print_r($row);
?>