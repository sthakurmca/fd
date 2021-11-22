    <?php //print_r($_POST);
      $msgs = "";
      if(isset($_POST['type'])){$type = $_POST['type'];}else{$type = "";}
      if(isset($_POST['product'])){$product = $_POST['product'];}else{$product = "";}
      if(isset($_POST['producttype'])){$producttype = $_POST['producttype'];}else{$producttype = "";}
      if(isset($_POST['productgrade'])){$productgrade = $_POST['productgrade'];}else{$productgrade = "";}
      if(isset($_POST['productmenu'])){$productmenu = $_POST['productmenu'];}else{$productmenu = "";}
      if(isset($_POST['ptype'])){$ptype = $_POST['ptype'];}else{$ptype = "";}
      if(isset($_POST['thickness'])){$thickness = $_POST['thickness'];}else{$thickness = "";}
      if(isset($_POST['width'])){$width = $_POST['width'];}else{$width = "";}
      if(isset($_POST['length'])){$length = $_POST['length'];}else{$length = "";}
      if(isset($_POST['search'])){
        $sqlitem = "SELECT * FROM item WHERE 
        item_type = '".$type."' AND
        item_category = '".$product."' AND
        item_sub_category = '".$producttype."' ";
        if($productmenu != ""){
          $sqlitem = $sqlitem. "AND item_manufacturer = '".$productmenu."' ";
        }
        if($productgrade != ""){
          $sqlitem = $sqlitem. "AND item_grade = '".$productgrade."' ";
        }
        if(trim($thickness) != ""){
          $sqlitem = $sqlitem. "AND item_thickness = '".trim($thickness)."' ";
        }
        if(trim($width) != ""){
          $sqlitem = $sqlitem. "AND item_width = '".trim($width)."' ";
        }
        if(trim($length) != ""){
          $sqlitem = $sqlitem. "AND item_length = '".trim($length)."'";
        }
        $resultitem = $conn->query($sqlitem);
      }//echo $sqlitem;
      if(isset($_POST['search'])){
        if($_POST['product'] == "Hot Rolled - HR"){
          $ptypeselect = ['HR Coil','HR SHEETS/Plates','HR Cut To Size','HR Slitted Coil'];
          $pgradeselect = ['IS 1074 - IS 1079','IS2062-E250','IS2062-E350','Chequered','BSK-46','Domex/Strenx','Hardox'];;
        }elseif($_POST['product'] == "Cold Rolled - CR"){
          $ptypeselect = ['CRCA Coil','CRCA Sheets','CRCA Cut To Size','CRCA Slitted Coil'];
          $pgradeselect = ['D Grade','ED Grade','EDD Grade'];
        }elseif($_POST['product'] == "Galvanized - GAL"){
          $ptypeselect = ['GL Coil','GL Sheets','GL Cut To Size','GL Slitted Coil'];
          $pgradeselect = ['1'];
        }
      }else{
        $ptypeselect = ['HR Coil','HR SHEETS/Plates','HR Cut To Size','HR Slitted Coil'];
        $pgradeselect = ['IS 1074 - IS 1079','IS2062-E250','IS2062-E350','Chequered','BSK-46','Domex/Strenx','Hardox'];;
      }
    ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Inventory Form</h4>
                  <form class="form-sample" method="POST" names="ps" id="ps" action="index.php?page=inventorys" enctype="multipart/form-data" onsubmit="return validateForm();">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Type</label>
                          <div class="col-sm-8">
                            <select class="form-control" name="type" id="type">
                              <option value="Steel" <?php if($type == "Steel"){echo "selected";} ?>>Steel</option>
                              <option value="Sanitary" <?php if($type == "Sanitary"){echo "selected";} ?>>Sanitary</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Product</label>
                          <div class="col-sm-8">
                            <select class="form-control" name="product" id="product" onchange="subcategory(this);">
                              <option value="Hot Rolled - HR" <?php if($product == "Hot Rolled - HR"){echo "selected";} ?>>Hot Rolled - HR</option>
                              <option value="Cold Rolled - CR" <?php if($product == "Cold Rolled - CR"){echo "selected";} ?>>Cold Rolled - CR</option>
                              <option value="Galvanized - GAL" <?php if($product == "Galvanized - GAL"){echo "selected";} ?>>Galvanized - GAL</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Product Type</label>
                          <div class="col-sm-8" id="ptype">
                            <select class="form-control" name="producttype" id="producttype">
                              <?php
                                foreach($ptypeselect as $value){
                                  echo"<option value='".$value."'";
                                  if($producttype == $value){echo "selected";}
                                  echo">".$value."</option>";
                                }
                              /*<option value="HR Coil" <?php if($producttype == "HR Coil"){echo "selected";} ?>>HR Coil</option>
                              <option value="HR SHEETS/Plates" <?php if($producttype == "HR SHEETS/Plates"){echo "selected";} ?>>HR SHEETS/Plates</option>
                              <option value="HR Cut To Size" <?php if($producttype == "HR Cut To Size"){echo "selected";} ?>>HR Cut To Size</option>
                              <option value="HR Slitted Coil" <?php if($producttype == "HR Slitted Coil"){echo "selected";} ?>>HR Slitted Coil</option>*/
                              ?>
                              </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Grade</label>
                          <div class="col-sm-8" id="pgrade">
                            <select class="form-control" name="productgrade" id="productgrade">
                              <?php
                              foreach($pgradeselect as $value){
                                echo"<option value='".$value."'";
                                if($productgrade == $value){echo "selected";}
                                echo">".$value."</option>";
                              }
                            /*<option value="IS 1074 - IS 1079" <?php if($type == "IS 1074 - IS 1079"){echo "selected";} ?>>IS 1074 - IS 1079</option>
                              <option value="IS2062-E250" <?php if($type == "IS2062-E250"){echo "selected";} ?>>IS2062 - E250</option>
                              <option value="IS2062-E350" <?php if($type == "IS2062-E350"){echo "selected";} ?>>IS2062 - E350 (HT52.5 /SAPH/QST/E355MC)</option>
                              <option value="Chequered" <?php if($type == "SChequeredteel"){echo "selected";} ?>>Chequered </option>
                              <option value="BSK-46" <?php if($type == "BSK-46"){echo "selected";} ?>>BSK-46</option>
                              <option value="Domex/Strenx" <?php if($type == "Domex/Strenx"){echo "selected";} ?>>Domex/Strenx</option>
                              <option value="Hardox" <?php if($type == "Hardox"){echo "selected";} ?>>Hardox</option>*/
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Manufacturer</label>
                          <div class="col-sm-8" id="ptype">
                            <select class="form-control" name="productmenu" id="productmenu">
                              <option value="" <?php if($productmenu == ""){echo "selected";} ?>>Please Select</option>  
                              <option value="SAIL" <?php if($productmenu == "SAIL"){echo "selected";} ?>>SAIL</option>
                              <option value="UTTAM" <?php if($productmenu == "UTTAM"){echo "selected";} ?>>UTTAM</option>
                              <option value="JSW" <?php if($productmenu == "JSW"){echo "selected";} ?>>JSW</option>
                              <option value="AMNS" <?php if($productmenu == "AMNS"){echo "selected";} ?>>AMNS</option>
                              <option value="TATA" <?php if($productmenu == "TATA"){echo "selected";} ?>>TATA</option>
                              <option value="JSPL" <?php if($productmenu == "JSPL"){echo "selected";} ?>>JSPL</option>
                            </select>
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Thickness</label>
                          <div class="col-sm-8">
                            <input  name="thickness" id="thickness" value="<?php echo $thickness;?>" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Width</label>
                          <div class="col-sm-8">
                            <input name="width" id="width" value="<?php echo $width;?>" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Length</label>
                          <div class="col-sm-8">
                            <input  name="length" id="length" value="<?php echo $length;?>" class="form-control" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <input type="submit" name="search" id="search" value="Search" class="btn btn-primary mr-2" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
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
      <script>
  function subcategory(id){
    if(id.value == "Hot Rolled - HR"){
      document.getElementById("ptype").innerHTML ="<select class='form-control' name='producttype' id='producttype'><option value='HR Coil' selected>HR Coil</option><option value='HR SHEETS/Plates'>HR SHEETS/Plates</option><option value='HR Cut To Size'>HR Cut To Size</option><option value='HR Slitted Coil'>HR Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML ="<select class='form-control' name='productgrade' id='productgrade'><option value='IS 1074 - IS 1079' selected>IS 1074 - IS 1079</option><option value='IS2062-E250'>IS2062 - E250</option><option value='IS2062-E350'>IS2062 - E350 (HT52.5 /SAPH/QST/E355MC)</option><option value='Chequered'>Chequered </option><option value='BSK-46' selected>BSK-46</option><option value='Domex/Strenx'>Domex/Strenx</option><option value='Hardox'>Hardox</option></select>";
    }else if(id.value == "Cold Rolled - CR"){
      document.getElementById("ptype").innerHTML = "<select class='form-control' name='producttype' id='producttype'><option value='CRCA Coil' selected>CRCA Coil</option><option value='CRCA Sheets'>CRCA Sheets</option><option value='CRCA Cut To Size'>CRCA Cut To Size</option><option value='CRCA Slitted Coil'>CRCA Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML = "<select class='form-control' name='productgrade' id='productgrade'><option value='D Grade' selected>D Grade</option><option value='ED Grade' >ED Grade</option><option value='EDD Grade' >EDD Grade</option></select>";
    }else if(id.value == "Galvanized - GAL"){
      document.getElementById("ptype").innerHTML = "<select class='form-control' name='producttype' id='producttype'><option value='GL Coil' selected>GL Coil</option><option value='GL Sheets'>GL Sheets</option><option value='GL Cut To Size'>GL Cut To Size</option><option value='GL Slitted Coil'>GL Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML = "<select class='form-control' name='productgrade' id='productgrade'><option value='1' selected>No Option available</option></select>";
    }
  }
  function toggel(id){
    if(id.value == "grn"){
      document.getElementById("buy").style.display = "block";
      document.getElementById("sell").style.display = "none";
    }else if(id.value == "outward"){
      document.getElementById("sell").style.display = "block";
      document.getElementById("buy").style.display = "none";
    }else{
      document.getElementById("sell").style.display = "none";
      document.getElementById("buy").style.display = "none";
    }
  }
  function validateForm(){
    let bb = document.getElementById("productmenu").value;
    let cc = document.getElementById("thickness").value;
    let dd = document.getElementById("width").value;
    let ee = document.getElementById("length").value;

    let a = document.getElementById("productaction").value;
    let b = document.getElementById("qtyb").value;
    let c = document.getElementById("pprice").value;
    let d = document.getElementById("source").value;
    let e = document.getElementById("invoice").value;
    let g = document.getElementById("hsn").value;
    let h = document.getElementById("sku").value;
    let i = document.getElementById("idate").value;
    let j = document.getElementById("qtys").value;
    let k = document.getElementById("sprice").value;
    let l = document.getElementById("onumber").value;
    let m = document.getElementById("pname").value;
    let n = document.getElementById("tnumber").value;
    let o = document.getElementById("odate").value;

    /*if(bb == ""){
        alert("Please select product manufacturer.");return false;
    }else if(cc == ""){
      alert("Please fill the Thickness.");return false;
    }else if(cc == ""){
      alert("Please fill the Width.");return false;
    }else if(cc == ""){
      alert("Please fill the Length.");return false;
    }else if(a == ""){
      alert("Please select the GRN/OutWard.");return false;
    }else{
      if(a == "grn"){

        if(b == ""){
          alert("Please fill the quantity.");return false;
        }else if(c == ""){
          alert("Please fill the price.");return false;
        }else if(d == ""){
          alert("Please fill the source.");return false;
        }else if(e == ""){
          alert("Please fill the invoice.");return false;
        }else if(g == ""){
          alert("Please fill the hsn.");return false;
        }else if(h == ""){
          alert("Please fill the sku.");return false;
        }else if(i == ""){
          alert("Please fill the date.");return false;
        }else{
          return true;
        }

      }else if(a == "outward"){
        if(j == ""){
          alert("Please fill the quantity.");return false;
        }else if(k == ""){
          alert("Please fill the price.");return false;
        }else if(l == ""){
          alert("Please fill the order number.");return false;
        }else if(m == ""){
          alert("Please fill party name.");return false;
        }else if(n == ""){
          alert("Please fill the truck number.");return false;
        }else if(o == ""){
          alert("Please fill the date.");return false;
        }else{
          return true;
        }
      }
    }*/
  }
</script>