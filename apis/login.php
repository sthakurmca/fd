<?php
  include("../conn.php");
  $_POST['Email/Phone number'] = "virat@test.com";
  $_POST['Password'] = "123456";
  $uname = $_POST['Email/Phone number'];
  $password = $_POST['Password'];
  $sql = "SELECT user_fname,user_id,user_type FROM user WHERE ( (user_email = '".$uname."') OR (user_phone = '".$uname."') ) AND user_password = '".$password."'";
  $result = $conn->query($sql); 
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $row['status'] = "Yes";
    json_encode($row);
  }else{
    $row['status'] = "No";
    json_encode($row);
  }
  print_r($row);
?>