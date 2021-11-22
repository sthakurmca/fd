<?php
  include("conn.php");
  $action = $_GET['a'];
  $id = $_GET['id'];;
  if($action == 0){
    //$sql = "DELETE FROM user WHERE user_id = ".$id ;
    $sql = "UPDATE user SET user_status = ".$_GET['s']." WHERE user_id = ".$id ;
    $result = $conn->query($sql);
    header('location:index.php?page=userlist&m=User Deleted.');
  }else{

  }
?>