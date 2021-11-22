<?php
  include("../conn.php");
  $_POST['Email'] = "vidfvdfrat@test.com";
  $email = $_POST['Email'];
  $_POST['Phone number'] = "123456789";
  $phone = $_POST['Phone number'];
  $_POST['Name'] = "123456";
  $fname = $_POST['Name'];
  $_POST['Firm name'] = "virat@test.com";
  $firmname = $_POST['Firm name'];
  $_POST['GST number'] = "123456";
  $gst = $_POST['GST number'];
  $_POST['Customer type'] = "123456";
  $type = $_POST['Customer type'];
  $_POST['Password'] = "123456";
  $password = $_POST['Password'];

  $sqldup = "SELECT * FROM user WHERE user_email ='".$email."' OR user_phone ='".$phone."'";
  $resultdup = $conn->query($sqldup); 

  if ($resultdup->num_rows > 0) {

    $row['status'] = "Email/Phone already exist.";
    json_encode($row);

  }else{

    $sqluser = "INSERT INTO user (user_fname, user_password, user_email, user_phone, user_gst, user_type, user_firmname, user_createdate)
    VALUES ('".$fname."', '".$password."', '".$email."','".$phone."', '".$gst."', '".$type."', '".$firmname."', '".date('Y-m-d h:i:s')."')";
    $result = $conn->query($sqluser); 
    if ($result) {
      $row['status'] = "Yes";
      json_encode($row);
    }else{
      $row['status'] = "Yes";
      json_encode($row);
    }

  }
  print_r($row);
?>