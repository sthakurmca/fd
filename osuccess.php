<?php //print_r($_POST);
  $sqlitem = "SELECT * FROM item WHERE item_quantity < 0";
  $resultitem = $conn->query($sqlitem);
  $sqliteml = "SELECT * FROM item WHERE item_quantity < ".$lowstock;
  $resultlitem = $conn->query($sqliteml);
?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Success Orders</h4>
                  <?php
                  if(isset($resultlitem->num_rows)){
                    echo"<div class='table-responsive pt-3'>
                        <table class='table table-bordered'>
                          <thead>
                            <tr>
                              <th>Number</th>  
                              <th>Material</th>
                              <th>Product</th>
                              <th>Grade</th>
                              <th>Thickness</th>
                              <th>Width</th>
                              <th>Length</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead><tbody>";
                    if ($resultlitem->num_rows > 0) {

                      while($rowitem = $resultlitem->fetch_assoc()){
                          echo"<tr class='table-success'>
                            <td>".$rowitem['stock_ref_invoice']."</td>
                            <td>".$rowitem['item_category']."</td>
                            <td>".$rowitem['item_sub_category']."</td>
                            <td>".$rowitem['item_grade']."</td>
                            <td>".$rowitem['item_thickness']."</td>
                            <td>".$rowitem['item_width']."</td>
                            <td>".$rowitem['item_length']."</td> 
                            <td>".$rowitem['stock_order_status']."</td>
                            <td>".$rowitem['stock_ref_invoice']."</td>
                          </tr>";

                      }echo"</tbody></table></div><br><br>";

                    }else{
                      echo"<tr><td colspan='8'>No item found.</td></tr></tbody></table></div><br><br>";
                    }
                  }
                  echo"<h4 class='card-title'>Inventory Outstandings</h4>";
                  if(isset($resultitem->num_rows)){
                    echo"<div class='table-responsive pt-3'>
                        <table class='table table-bordered'>
                          <thead>
                            <tr>
                              <th>Type</th>
                              <th>Material</th>
                              <th>Product</th>
                              <th>Grade</th>
                              <th>Thickness</th>
                              <th>Width</th>
                              <th>Length</th>
                              <th>Quantity</th>
                            </tr>
                          </thead><tbody>";
                    if ($resultitem->num_rows > 0) {

                      while($rowitem = $resultitem->fetch_assoc()){
                          echo"<tr class='table-warning'>
                            <td>".$rowitem['item_type']."</td>
                            <td>".$rowitem['item_category']."</td>
                            <td>".$rowitem['item_sub_category']."</td>
                            <td>".$rowitem['item_grade']."</td>
                            <td>".$rowitem['item_thickness']."</td>
                            <td>".$rowitem['item_width']."</td>
                            <td>".$rowitem['item_length']."</td>
                            <td>".number_format((float)$rowitem['item_quantity'], 3, '.', '')."</td>
                          </tr>";

                      }echo"</tbody></table></div><br><br>";

                    }else{
                      echo"<tr><td colspan='8'>No item found.</td></tr></tbody></table></div><br><br>";
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php //include("footer.php");?>
    </div>
      <!-- main-panel ends -->