<?php
  session_start();
  date_default_timezone_set('Asia/Calcutta');
  $date = date('Y-m-d h:i:s', time());
  include("conn.php");
  if(isset($_GET['type'])){
    $sql = "SELECT item_quantity FROM item WHERE item_id=".$_GET['itemid'];
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row['item_quantity'] >= $_GET['qty']){
      $sqluser = "INSERT INTO stock (stock_item_id, stock_user_id, stock_quantity, stock_inward_date, stock_ref_invoice, stock_type, stock_sellprice)
      VALUES ('".$_GET['itemid']."', '".$_SESSION['userid']."', '".$_GET['qty']."','".$date."', '".$_GET['order']."', '2','".$_GET['sprice']."')";
      $conn->query($sqluser);
      $sqlitem = "UPDATE item SET item_quantity = item_quantity-".$_GET['qty']." WHERE item_id = ".$_GET['itemid'];
      $conn->query($sqlitem);
    }else{
      echo "Stock Shortage.";die();
    }
  }else{
    $sqluser = "INSERT INTO stock (stock_item_id, stock_user_id, stock_quantity, stock_inward_date, stock_ref_invoice, stock_hsn, stock_sku, stock_purchased_price, stock_negotiable_price)
    VALUES ('".$_GET['itemid']."', '".$_SESSION['userid']."', '".$_GET['qty']."','".$date."', '".$_GET['invoice']."', '".$_GET['hsn']."','".$_GET['sku']."', '".$_GET['pprice']."', '".$_GET['nprice']."')";
    $conn->query($sqluser);
    $sqlitem = "UPDATE item SET item_quantity = item_quantity+".$_GET['qty']." WHERE item_id = ".$_GET['itemid'];
    $conn->query($sqlitem);
  }
  $sql = "SELECT item_quantity FROM item WHERE item_id=".$_GET['itemid'];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  echo number_format((float)$row['item_quantity'], 4, '.', '');
?>