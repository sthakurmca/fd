<?php //print_r($_POST);
  $sqlitem = "SELECT * FROM item";
  $resultitem = $conn->query($sqlitem);
?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                <h4 class="card-title">Inventry History</h4>
                  <?php
                  if(isset($resultitem->num_rows)){
                    /*echo"<div class='table-responsive pt-3'>
                        <table class='table table-bordered'>
                          <thead>
                            <tr>
                              <th>Type</th>
                              <th>Material</th>
                              <th>Product</th>
                              <th>Grade</th>
                              <th>Thickness</th>
                              <th>Width</th>
                              <th>Quantity</th>
                            </tr>
                          </thead></table></div>";*/
                    if ($resultitem->num_rows > 0) {
                      $i = 0;
                      while($rowitem = $resultitem->fetch_assoc()){
                        $i=$i+1;
                          echo"<div class='table-responsive pt-3'>";
                          if($i!=1){
                            echo "<br><br>";
                          }
                          echo"<p class='card-description'>#".$i."</p>
                          <table class='table table-bordered'><tbody>
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
                          <tr class='table-warning'>
                            <td>".$rowitem['item_type']."</td>
                            <td>".$rowitem['item_category']."</td>
                            <td>".$rowitem['item_sub_category']."</td>
                            <td>".$rowitem['item_grade']."</td>
                            <td>".$rowitem['item_thickness']."</td>
                            <td>".$rowitem['item_width']."</td>
                            <td>".$rowitem['item_length']."</td>
                            <td>".number_format((float)$rowitem['item_quantity'], 3, '.', '')."</td>
                          </tr></tbody></table></div>";

                          $sqlstock = "SELECT * FROM stock WHERE 
                          stock_item_id = ".$rowitem['item_id']." AND stock_type = 1 ORDER BY stock_type DESC";
                          $resultstock = $conn->query($sqlstock);

                            
                          if ($resultstock->num_rows > 0) {
                            echo"<div class='table-responsive pt-3'>
                            <p class='card-description'>GRN</p>
                            <table class='table table-bordered'>
                              <thead>
                                <tr>
                                  <th>Invoice</th>
                                  <th>HSN</th>
                                  <th>SKU</th>
                                  <th>Purchase Price</th>
                                  <th>Source</th>
                                  <th>Quantity</th>
                                  <th>Inward Date</th>
                                </tr>
                              </thead><tbody>";
                            while($rowstock = $resultstock->fetch_assoc()){//print_r($rowstock);
                              echo"<tr class='table-danger'>
                              <td>".$rowstock['stock_ref_invoice']."</td>
                              <td>".$rowstock['stock_hsn']."</td>
                              <td>".$rowstock['stock_sku']."</td>
                              <td>".$rowstock['stock_purchased_price']."</td>
                              <td>".$rowstock['stock_source']."</td>
                              <td>".number_format((float)$rowstock['stock_quantity'], 3, '.', '')."</th>
                              <td>".date('d/m/Y', strtotime($rowstock['stock_inward_date']))."</td></tr>";
                            }echo "</tbody></table></div>";
                          }else{
                            //echo"<tr><td colspan='7'>No GRN Found.</td></tr></tbody></table></div>";
                          }

                          $sqlstock = "SELECT * FROM stock WHERE 
                          stock_item_id = ".$rowitem['item_id']." AND stock_type = 2 ORDER BY stock_type DESC";
                          $resultstock = $conn->query($sqlstock);

                            
                            if ($resultstock->num_rows > 0) {
                              echo"<div class='table-responsive pt-3'>
                              <p class='card-description'>OutWard</p>
                              <table class='table table-bordered'>
                                <thead>
                                  <tr>
                                    <th>OrderNo</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Party</th>
                                    <th>Truck</th>
                                    <th>Outward Date</th>
                                  </tr>
                                </thead><tbody>";
                              while($rowstock = $resultstock->fetch_assoc()){//print_r($rowstock);
                              echo"<tr class='table-success'>
                              <td>".$rowstock['stock_ref_invoice']."</td>
                              <td>".number_format((float)$rowstock['stock_sellprice'], 3, '.', '')."</th>
                              <td>".number_format((float)$rowstock['stock_quantity'], 3, '.', '')."</th>
                              <td>".$rowstock['stock_customer']."</td>
                              <td>".$rowstock['stock_truck']."</th>
                              <td>".date('d/m/Y', strtotime($rowstock['stock_inward_date']))."</td></tr>";
                            }echo "</tbody></table></div>";
                          }else{
                            //echo"<tr><td colspan='7'>No OutWard found.</td></tr></tbody></table></div>";
                          }

                      }

                    }else{
                      echo"<tr><td colspan='7'>No item found.</td></tr></tbody></table></div>";
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