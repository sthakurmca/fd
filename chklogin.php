<?php
  session_start();
  if(!(isset($_SESSION['fname']))){
    header('location:login.php');
  }
?>