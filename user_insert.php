<?php
	$url = "https://api.adalo.com/v0/apps/e414ad97-4bd4-49ff-b8c9-d51e2c4ea9ca/collections/t_fc0417af093e4a26b0c96c908a0521d6";
  
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
  $request_headers = array(
    "Content-Type:application/json",
    "Authorization:Bearer 04dvn25hq8otzolrjcqstwcbt"
  );

  curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  
  $resp=curl_exec($curl);
  curl_close($curl);
  //print_r($resp);
  $resparray = json_decode($resp);
  //print_r($resparray);echo "<br><br><br><br><br>";die();
  include("conn.php");
  $sqlitem = "SELECT user_phone FROM user";
  $resultitem = $conn->query($sqlitem);
  $phone_number = array();
  if ($resultitem->num_rows > 0) {
    while($rowitem = $resultitem->fetch_assoc()){
      array_push($phone_number,$rowitem['user_phone']);
    }
  }
  $insert_value = "";
  foreach($resparray->records as $item){
    if (!(in_array($item->Username, $phone_number))){
      $insert_value = $insert_value.",('".$item->Email."','".$item->{'Full name'}."','".$item->{'Firm Name'}."','".$item->{'GST number'}."','".$item->{'TAN number'}."','".$item->Username."','".$item->{'Customer type'}[0]."','".$item->{'Payment credit?'}."','".date('Y-m-d h:i:s')."')";
    }
  }
  $insert_value = ltrim($insert_value, ',');
  $sqluser = "INSERT INTO user (user_email, user_fname, user_firmname, user_gst, user_tannumber, user_phone, user_type, user_credit, user_createdate)
  VALUES ".$insert_value;
  if(trim($insert_value) != ""){
    $conn->query($sqluser);
  }
  ?>